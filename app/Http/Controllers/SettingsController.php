<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\Setting;
use Mail;
use App\Intermediair;
use App\User;
use Custommade;


class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Intermediairs mogen de index niet zien        
        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Een intermediair probeerde de settings-indexpagina te laden, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }


        $settings = DB::select('select * from settings');
        $usersentries = DB::select('select id, achternaam from users');

        $userarray = array();
        $settingarray = array();

        foreach($settings as $setting) {
            $settingarray[$setting->id] = array(
                'setting' => $setting->setting,
                'value' => $setting->value,
                'lastTamperedUser_id' => $setting->lastTamperedUser_id,
                'updated_at' => $setting->updated_at
            );  
        }

        foreach($usersentries as $userentry) {
            $userarray[$userentry->id] = $userentry->achternaam;
        }

        return view('settings.index', ['settingarray' => $settingarray, 'userarray'=>$userarray]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Intermediairs en raadplegers mogen niets wijzigen      
        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Een intermediair probeerde een settings-instelling te wijzigen, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        } elseif(($user->usertype == 2)){            
            Log::info('Een raadpleger probeerde een settings-instelling te wijzigen, userid: '.$user->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }


        if ($id==4) {// inschijving openen of sluiten

//dd($request->value);
            

            if ($request->value == "1") {
                
                $this->sendMailToIntermediairs ("inschrijving_sluiten");
            } else {

                $this->sendMailToIntermediairs ("inschrijving_open");

            }
        }



        if ($id==6) {// Downloadpagina openen of sluiten

//dd($request->value);
            

            if ($request->value == "1") {

                $open_gesloten = Setting::find('4');
                

                if ($open_gesloten->value == "1") {
                    $this->sendMailToIntermediairs ("downloadpagina_open");
                } else {
                    return redirect('/settings/')->with('message', 'Instelling niet gewijzigd; downloadpagina kan alleen worden geopend als de inschrijvingen zijn gesloten.');
                }
                
                
            } else {

                $this->sendMailToIntermediairs ("downloadpagina_sluiten");

            }
        }

        $setting = Setting::find($id);
        $setting->update($request->all());

        return redirect('/settings/')->with('message', 'Instelling gewijzigd');


    }


    public function getReadable () {
        
        $settings = Setting::All();
        $arr = array();

        foreach ($settings as $setting) {

            $arr[$setting->setting] = $setting->value;


        }
        
        return $arr;

    }



    public function sendMailToIntermediairs ($type = false) {

        $emailadressen_intermediairs = array();
        $intermediairs = Intermediair::All();

        foreach ($intermediairs as $intermediair) {
            $emailadressen_intermediairs[] = $intermediair->user->email;
        }

        //dd($emailadressen_intermediairs);

        /*
        *   stuur een mail naar de intermediairs. 
        */

        if ($type=="inschrijving_sluiten") {
            $maildata = [
                    'mailto' => $emailadressen_intermediairs
            ];
            try {
                Mail::send('emails.inschrijvinggesloten', $maildata, function ($message) use ($maildata){
                    $message->from('noreply@sinterklaasbank.nl', 'Stichting De Sinterklaasbank');
                    
                    $message->bcc($maildata['mailto']);
                        
                    $message->subject('Bericht van de Sinterklaasbank: de inschrijvingen zijn gesloten');
                });
            } 
                catch(\Exception $e){
                // catch code
            }

        }

        if ($type=="inschrijving_open") {
            $maildata = [
                    'mailto' => $emailadressen_intermediairs
            ];
            try {
            Mail::send('emails.inschrijvinggeopend', $maildata, function ($message) use ($maildata){
                $message->from('noreply@sinterklaasbank.nl', 'Stichting De Sinterklaasbank');
                
                $message->bcc($maildata['mailto']);
                    
                $message->subject('Bericht van de Sinterklaasbank: de inschrijvingen zijn geopend');
            });
            } 
                catch(\Exception $e){
                // catch code
            }

        }      

        if ($type=="downloadpagina_open") {
            $maildata = [
                    'mailto' => $emailadressen_intermediairs
            ];
            try {
            Mail::send('emails.downloadpagina_open', $maildata, function ($message) use ($maildata){
                $message->from('noreply@sinterklaasbank.nl', 'Stichting De Sinterklaasbank');
                
                $message->bcc($maildata['mailto']);
                    
                $message->subject('Bericht van de Sinterklaasbank: uw downloadpagina is geopend');
            });
            } 
                catch(\Exception $e){
                // catch code
            }

        }    

        if ($type=="downloadpagina_sluiten") {
            $maildata = [
                    'mailto' => $emailadressen_intermediairs
            ];
            try {
            Mail::send('emails.downloadpagina_sluiten', $maildata, function ($message) use ($maildata){
                $message->from('noreply@sinterklaasbank.nl', 'Stichting De Sinterklaasbank');
                
                $message->bcc($maildata['mailto']);
                    
                $message->subject('Bericht van de Sinterklaasbank: uw downloadpagina is gesloten');
            });
            } 
                catch(\Exception $e){
                // catch code
            }

        }           


        /*
        *   Einde mail
        */
    }





/*
*   Hier de functies om een algemene email te versturen aan de intermediairs. 
*
*/

    public function sendmailform () {

        /*
        *   Deze functie is voor het gemak in de settings geplaatst (niet helemaal de juiste plek)
        *   Hij verstuurt een tekst naar alle intermediairs.
        *
        *   $preview = true (verzend geen mail, toont alleen een preview)
        */
        
        return view('mail2intermediair');

    }   


    public function sendmail (Request $request) {

        /*
        *   Deze functie is voor het gemak in de settings geplaatst (niet helemaal de juiste plek)
        *   Hij verstuurt een tekst naar alle intermediairs.
        *
        *   $preview = true (verzend geen mail, toont alleen een preview)
        */
        

        $emailadressen = array();
        $users = User::All();

        foreach ($users as $user) {
            $emailadressen[] = $user->email;
        }

        //dd($emailadressen_intermediairs);

        /*
        *   stuur een mail naar de intermediairs. 
        */

        $maildata = [
                    'mailto' => $emailadressen,
                    'emailmessage' => $request->tekstvooremail,
                    'preview' => false
            ];

            Mail::send('emails.algemenemail', $maildata, function ($message) use ($maildata){               
                
                $message->bcc($maildata['mailto']);
                    
                $message->subject('Bericht van de Sinterklaasbank: informatiebericht');
            });

        

        return redirect('/home/')->with('message', 'De email is verzonden aan alle gebruikers.');

    }        


    public function emailpreview() {

        /*
        *   Deze functie is voor het gemak in de settings geplaatst (niet helemaal de juiste plek)
        *   Hij toont de emailtemplate voor de mail aan alle intermediairs.
        *
        */
        
        return view('emails.algemenemail', ['preview' => true]);
    }      

/*
*   Einde algemene emailfuncties
*
*/    

}
