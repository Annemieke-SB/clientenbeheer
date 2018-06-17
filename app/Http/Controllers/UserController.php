<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Mail\ChangeEmailVerification;
use App\Mail\EmailActivationtoggle;
use App\Family;
use App\Kid;
use App\User;
use App\Intertoys;
use App\Setting;
use App\Barcode;
use App\Blacklist;
use Mail;
use DB;
use Html;
use Custommade;
use App\Notifications\wachtwoordreset;


class UserController extends Controller
{
    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new wachtwoordreset($token));
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggedinuser = Auth::user();


        if (request()->input('sort')=='ad') { 
            // achternaam ascending
            $sorts = "'achternaam', 'DESC'";

        } else { 
            // achternaam descending
            $sorts = "'achternaam', 'ASC'";

        } 

        if (request()->has('na')) { 
            // Niet geactiveerde gebruikers 



            $users = User::where('activated', '0')->orderBy($sorts)->paginate(100)->appends('filter', request('filter'));

        } elseif (request()->input('filter')=='izg') {

            // Toon intermediairs zonder gezinnen

            $users = User::whereDoesntHave('familys')->orderBy($sorts)->paginate(100)->appends('filter', request('filter'));

        } elseif (request()->input('filter')=='izk') {

            // Toon intermediairs zonder kinderen

            $users = User::whereDoesntHave('kids')->orderBy('achternaam', 'ASC')->paginate(100)->appends('filter', request('filter'));

        } elseif (request()->input('filter')=='ipd') {

            // Toon intermediairs die nog pdf's moeten downloaden

            $users = User::whereHas('barcodes', function($query){
                $query->whereNull('downloadedpdf');
            })->paginate(100)->appends('ipd', request('ipd'));

        } elseif (request()->input('filter')=='igg') {

            // Toon intermediairs met nog goed te keuren gezinnen

            $users = User::whereHas('familys', function($query){
                $query->where('aangemeld', 1)->where('goedgekeurd', 0);
            })->paginate(100)->appends('filter', request('filter'));  

        } elseif (request()->input('filter')=='iga') {

            // Toon intermediairs waarvan nog gezinnen moeten worden aangemeld

            $users = User::whereHas('familys', function($query){
                $query->where('aangemeld', 0)->where('goedgekeurd', 0);
            })->paginate(100)->appends('filter', request('filter'));   

        } elseif (request()->input('filter')=='iai') {

            // Toon intermediairs met andere initiatieven

            $users = User::whereHas('familys', function($query){
                $query->where('andere_alternatieven', 1);
            })->paginate(100)->appends('filter', request('filter'));   

        } else {

            // Geen filter

            $users = User::orderBy('achternaam', 'ASC')->paginate(100);
        }

        

        // Intermediairs mogen de index niet zien        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde de gebruikers-indexpagina te laden, userid: '.$user->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        return view('users.index', ['users' => $users]);
    }

    public function toggleactive($id)
    {

        
        $loggedinuser = Auth::user();

        // Intermediairs mogen de activatie niet wijzigen        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde de gebruikers-toggleactive te wijzigen, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if(($loggedinuser->usertype == 2)){
            
            Log::info('Een raadpleger probeerde de gebruikers-toggleactive te wijzigen, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $user = User::find($id);

        if ($user->activated==1) {
            $user->activated=0;
            $maildata = [
                'titel' => "Uw account is gedeactiveerd",
                'mailmessage' => "Uw account in de clientenbeheer van de Sinterklaasbank is gedeactiveerd en kunt nu niet meer inloggen. Is dit volgens u onterecht, neem dan contact op met info@sinterklaasbank.nl.",
                'voornaam' => $user->voornaam,
                'email'=>$user->email
            ];
            
            
        } else {
            $user->activated=1;

            $maildata = [
                'titel' => "Uw account is geactiveerd",
                'mailmessage' => "Uw account in clientenbeheer van de Sinterklaasbank is geactiveerd. Ga naar " . url('/home') . " om in te loggen. Onze doelstelling is gezinnen thuis op traditionele wijze het Sinterklaasfeest te laten vieren ook als dit financieel niet mogelijk is. Wij willen nadrukkelijk aangeven dat wij er niet zijn voor kerstcadeaus, verjaardagscadeaus of gewoon een extra cadeau. Derhalve zijn onze cadeaubonnen niet meer te gebruiken na 5 december " . date('Y') ."." ,
                'voornaam' => $user->voornaam,
                'email'=>$user->email
            ];
        }

        Mail::send('emails.activationtoggle', $maildata, function ($message) use ($maildata){
            $message->from('noreply@sinterklaasbank.nl', 'Stichting de Sinterklaasbank');
            
            $message->to($maildata['email']);
                
            $message->subject('Bericht van de Sinterklaasbank: ' . $maildata['titel']);
        });

        
        $user->save();

        return redirect('users/index/')->with('message', 'Gebruikersactivatie van '. $user->voornaam. ' '. $user->achternaam. ' gewijzigd. De gebruiker is automatisch op de hoogte gebracht van deze wijziging. Dit heeft overigens geen invloed op de ingevoerde gezinnen en kinderen. Als je die wilt uitsluiten moet je de gebruiker verwijderen.');
    }



    public function manualemailverification($id)
    {

        
        $loggedinuser = Auth::user();

        // Intermediairs mogen de activatie niet wijzigen        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde de user/manualemailverification te benaderen, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if(($loggedinuser->usertype == 2)){
            
            Log::info('Een raadpleger probeerde de user/manualemailverification te benaderen, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $user = User::find($id);        
        $user->verified();


        return redirect('user/show/'. $user->id)->with('message', 'Emailverificatie van '. $user->voornaam. ' '. $user->achternaam. ' handmatig bevestigd. De gebruiker is kan nu inloggen (nadat het account is goedgekeurd).');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $id)){
            
            Log::info('Een intermediair probeerde een andere gebruiker te bekijken (user.show) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        return view('users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if($loggedinuser->id != $id){
            
            Log::info('Een gebruiker probeerde een andere gebruiker te wijzigen (user.edit) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft geprobeerd gegevens van een andere gebruiker aan te passen. Dit kan niet.');
        }

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatename(Request $request)
    {
        $user = User::findOrFail($request->id);

        $input = $request->all();

        $user->fill($input)->save();

        return redirect('user/edit/'.$user->id)->with('message', 'Gegevens gewijzigd');
    }

    public function updateemail(Request $request)
    {
        $user = User::findOrFail($request->id);
        $oude_mail = $user->email;

        $input = $request->all();

        if (empty($request->email1) || empty($request->email2)) {
            return redirect('user/edit/'.$user->id)->with('message', 'U had niet alle emailadres-velden ingevuld. Het emailadres is niet gewijzigd!');
        }

        // Als het emailadres is gewijzigd dan moet deze weer geverifieerd worden.
        if ($request->email1 == $request->email2) {


            // Als het nieuwe emailadres al in de db voorkomt
            $emailcheck = User::where('email', '=', $request->email1)->first();

            if ($emailcheck) {
                return redirect('user/edit/'.$user->id)->with('message', 'Het emailadres is al bij ons bekend. De wijziging is niet doorgevoerd!');
            } 

            $user->email_token = str_random(10);
            $user->emailverified = 0;
            $user->email = $request->email1;
            
            $user->fill($input)->save();

            $emailmessage = new ChangeEmailVerification(new User(['email_token' => $user->email_token, 'voornaam'=>$user->voornaam]));
            Mail::to($user->email)->send($emailmessage);

            /*
            * Het oude emailadres krijgt ook een email
            */

            $maildata = [
                'titel' => "Uw emailadres is gewijzigd",
                'voornaam' => $user->voornaam,
                'nieuweemail' => $request->email1,
                'email'=>$user->email
            ];
            

            Mail::send('emails.notifyEmailChange', $maildata, function ($message) use ($maildata){
                $message->from('noreply@sinterklaasbank.nl', 'Stichting de Sinterklaasbank');
                
                $message->to($maildata['email']);
                    
                $message->subject('Bericht van de Sinterklaasbank: ' . $maildata['titel']);
            });

            /*
            * Einde oude emailadres
            */

            //Custommade::sendUserEmail($oude_mail, 'Uw emailadres is gewijzigd naar '.$request->email1 .'. Als dit niet klopt, neem dan zo spoedig mogelijk contact op met webmaster@sinterklaasbank.nl.');

            Auth::logout();
            return redirect('login')->with('message', 'Gegevens gewijzigd. Omdat het emailadres is gewijzigd is er een verificatiemail naar het nieuwe emailadres ('.$request->email1.') gestuurd. Na het klikken op de link kunt u pas weer inloggen.');
        }
        else {
            return redirect('user/edit/'.$user->id)->with('message', 'De twee emailadres-velden kwamen niet overeen. Het emailadres is niet gewijzigd!');
        }
    }

    public function updatepassword(Request $request)
    {
        $user = User::findOrFail($request->id);

        $input = $request->all();

        // Als het emailadres is gewijzigd dan moet deze weer geverifieerd worden.
        if ($request->pass1 == $request->pass2) {
            
            if (strlen($request->pass1)<8) {
                return redirect('user/edit/'.$user->id)->with('message', 'Het opgegeven nieuwe wachtwoord moet minimaal 8 karakters hebben. Het wachtwoord is niet gewijzigd.');
            }

            $user->password = bcrypt($request->pass1);
            
            $user->fill($input)->save();

            return redirect('user/edit/'.$user->id)->with('message', 'Uw wachtwoord is gewijzigd.');
        }

       

        return redirect('user/edit/'.$user->id)->with('message', 'De wachtwoordvelden kwamen niet overeen. Het wachtwoord is niet gewijzigd.');
    }


    public function downloads($id)
    {


        $user = Auth::user();


        // Intermediairs mogen de downloadpagina zien        
        if((!$user->usertype == 3)){
            $usertoshow = User::find($id);
        } else {
            $usertoshow = $user;
        }

        if ($usertoshow->usertype == 1) {
            return redirect('extrabarcodes')->with('message', 'Omdat de gebruiker een admin is ben je doorverwezen naar de geclaimde extra barcodes.');
        }

        $goedgekeurde_families = Family::where([
                ['goedgekeurd', '=', '1'],
                ['user_id', '=', $usertoshow->id],
            ])->with('kids')->get();


        return view('users.downloads', ['families' => $goedgekeurde_families]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedinuser = Auth::user();

       if (Setting::get('inschrijven_gesloten') == 1) { // als inschrijven is gesloten, dan kan er niets vernietigd worden
            return redirect('users/index')->with('message', 'Het is niet mogelijk om gebruikers te verwijderen nadat de inschrijvingen zijn gesloten. Dit omdat er mogelijk kinderen aan gekoppeld zitten die al een PDF tot hun beschikking hebben. Je zou wel de gebruiker (intermediair) kunnen deactiveren in het gebruikersoverzicht.'); 
        }

        if ($loggedinuser->usertype==1){

            $user = User::findOrFail($id);

		try{
			$user->destroyFamilys(); // De familie en kinderen worden gewist, barcodes losgekoppeld
			$user->delete();
		}                    
		catch (\Exception $e){
            		return redirect('users/index')->with('message', 'De gebruiker kon niet worden verwijderd, er waren al barcodes gedownload.');
			
		}

            return redirect('users/index')->with('message', 'De gebruiker is verwijderd (en in het geval van een intermediair ook alle bijbehorende gezinnen en kinderen)');

        } else 
        {
            Log::info('Een niet-admin probeerde een intermediair te verwijderen (intermediair.destroy) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
    }


}
