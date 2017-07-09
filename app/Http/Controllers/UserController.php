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
use Mail;
use DB;
use Html;
use Custommade;
use App\Intermediair;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(15)->get();
        $loggedinuser = Auth::user();

        // Intermediairs mogen de index niet zien        
        if(($loggedinuser->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $loggedinuser->id)->first();
            Log::info('Een intermediair probeerde de gebruikers-indexpagina te laden, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        return view('users.index', ['users' => $users]);
    }

    public function toggleactive($id)
    {

        
        $loggedinuser = Auth::user();

        // Intermediairs mogen de activatie niet wijzigen        
        if(($loggedinuser->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $loggedinuser->id)->first();
            Log::info('Een intermediair probeerde de gebruikers-toggleactive te wijzigen, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
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
                'mailmessage' => "Uw account in clientenbeheer van de Sinterklaasbank is geactiveerd. Ga naar " . url('/home') . " om in te loggen." ,
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
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $loggedinuser->id)->first();
            Log::info('Een intermediair probeerde de user/manualemailverification te benaderen, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
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


    public function redirecttointermediair($id)
    {
        
        $intermediair = DB::table('intermediairs')->where('user_id', $id)->first();
        if (!isset($intermediair->id)) {
            return redirect()->back()->with('message','De instelling van de intermediair bestaat (nog) niet.');
        }
        return redirect('intermediairs/show/'. $intermediair->id);

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
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $user->id)){
            
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
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $user->id)){
            
            Log::info('Een intermediair probeerde een andere gebruiker te wijzigen (user.edit) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedinuser = Auth::user();


        /*
        *
        * Settings leesbaar maken
        * Om deze in de view te krijgen: $settings['inschrijven_gesloten']
        *
        */

            $settings = Setting::all();
            $settings_arr=array();
            foreach ($settings as $setting) {
                $settings_arr[$setting->setting] = $setting->value;
            }

        /*
        * --
        */
        


        if ($settings_arr['inschrijven_gesloten'] == 1) { // als inschrijven is gesloten, dan kan er niets vernietigd worden
            return redirect('users/index')->with('message', 'Het is niet mogelijk om gebruikers te verwijderen nadat de inschrijvingen zijn gesloten. Dit omdat er mogelijk kinderen aan gekoppeld zitten die al een PDF tot hun beschikking hebben. Je zou wel de gebruiker (intermediair) kunnen deactiveren in het gebruikersoverzicht.'); 
        }

        if ($loggedinuser->usertype==1){

            $user = User::findOrFail($id);

            if ($user->usertype==3){
                $intermediair = Intermediair::where('user_id', '=', $user->id)->first(); 

                if ($intermediair) {
                    $familys = Family::where('intermediair_id', '=', $intermediair->id)->get(); 
                    

                     foreach($familys as $family) {

                        /* 
                        * Routine om de evt barcodes los te koppelen
                        *
                        */
                        //$kids = DB::table('kids')->where('family_id', '=', $family->id)->get();
                        $kids = Kid::where('family_id', '=', $family->id)->get(); 
                        

                        foreach ($kids as $kid) {
                            if ($kid->barcode) {
                                $barcode = Barcode::findOrFail($kid->barcode->id);
                                $barcode->kid_id = NULL;
                                $barcode->save();  
                            }
                        }

                        /*
                        * Einde barcode routine
                        */

                        DB::table('kids')->where('family_id', '=', $family->id)->delete();
                    } 

                    DB::table('familys')->where('intermediair_id', '=', $intermediair->id)->delete();                  
                }

               DB::table('intermediairs')->where('user_id', '=', $user->id)->delete();
            }

            User::destroy($id); // 1 way 

            return redirect('users/index')->with('message', 'De gebruiker is verwijderd (en in het geval van een intermediair ook alle bijbehorende families en kinderen)');

        } else 
        {
            Log::info('Een niet-admin probeerde een intermediair te verwijderen (intermediair.destroy) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
    }
}
