<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\Family;
use App\Kid;
use App\Barcode;
use App\Setting;
use Custommade;
use Mail;

class FamilyController extends Controller
{

    public function index()
    {
        $familys = DB::table('familys')->get();

        return view('familys.index', ['familys' => $familys]);
    }


    public function show($id)
    {


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


        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen eigen families bekijken 
        */

        $loggedinuser = Auth::user();
        
        //$family = DB::table('familys')->where('id', $id)->first();
        $family = Family::find($id);
        $intermediair = Family::find($id)->user;
        $kids = Family::find($id)->kids;
        //$eigenaar = DB::table('users')->where('id', $intermediair->user_id)->first();
        $min_leeftijd_target = Setting::find(1);
        $max_leeftijd_target = Setting::find(2);
        $max_leeftijd_sibling = Setting::find(3);

        // Intermediairs mogen geen andere familys zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $intermediair->user_id)){
            
            Log::info('Een intermediair probeerde de een andere familie te bekijken (family.show) te laden, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }        

        return view('familys.show', ['intermediair' => $intermediair, 'family' => $family, 'kids' => $kids,  'min_leeftijd_target'=>$min_leeftijd_target, 'max_leeftijd_target'=>$max_leeftijd_target, 'max_leeftijd_sibling'=>$max_leeftijd_sibling, 'settings'=>$settings_arr]);
    }    



    public function create($id) // Dit ID is een intermediair-id
    {
        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen families onder eigen ID toevoegen 
        */
	
        $user = DB::table('users')->where('id', $id)->first();
        $loggedinuser = Auth::user(); 
        //$intermediair_vanloggedinuser = DB::table('intermediairs')->where('user_id', $loggedinuser->id)->first();
     
        // Intermediairs mogen alleen familys aanmaken onder eigen id       
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $id)){
            
            Log::info('Een intermediair probeerde de een familie aan te maken (family.create) bij een andere intermediair: '.$loggedinuser->id);
            return redirect('user/show/'.$loggedinuser->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }



        return view('familys.create', ['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateFamilyRequest $request)
    {

        $id = Family::create($request->all())->id;

        return redirect('family/show/'.$id)->with('message', 'Familie toegevoegd');
    }


    public function destroy($id)
    {

        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen eigen gezinnen deleten
            - Kinderen worden ook meteen gedelete  
            - raadplegers mogen niet wissen            
        */

        $loggedinuser = Auth::user();
        $intermediair = Family::find($id)->intermediair;
        $family = Family::find($id);


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
            return redirect('intermediairs')->with('message', 'Het is niet mogelijk om gezinnen te verwijderen nadat de inschrijvingen zijn gesloten. Dit omdat er mogelijk kinderen aan gekoppeld zitten die al een PDF tot hun beschikking hebben. Je zou wel de gebruiker (intermediair) kunnen deactiveren in het gebruikersoverzicht.'); 
        }



        /*
        * Een intermediair kan een kind uit een aangemeld gezin niet wissen
        *
        */

        if ($family->aangemeld == 1 && $loggedinuser->usertype == 3){

            Log::warning('Een intermediair probeerde een aangemeld gezin te verwijderen (family.destroy), userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft een gezin geprobeerd te wissen, maar het gezin is al aangemeld.');          
        }



        if(($loggedinuser->usertype == 2)){
            
            Log::info('Een raadpleger probeerde de een familie te verwijderen (family.destroy), userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft iets geprobeerd te wissen, maar dat mag niet als raadpleger.');
        }

        // Intermediairs mogen geen andere familys deleten dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $intermediair->user_id)){
            
            Log::info('Een intermediair probeerde de een andere familie te verwijderen (family.destroy), userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }


        $family = DB::table('familys')->where('id', $id)->first();
        DB::table('kids')->where('family_id', '=', $id)->delete();
        Family::destroy($id); // 1 way 
        return redirect('intermediairs/show/'.$family->intermediair_id)->with('message', 'Gezin verwijderd');
    }


    public function edit($id)
    {

        $family = Family::find($id);
        $intermediair = $family->intermediair;
        
        $eigenaar = DB::table('users')->where('id', $intermediair->user_id)->first();
        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $intermediair->user_id)){
            
            Log::info('Een intermediair probeerde een andere familie te wijzigen (family.edit) te laden, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }



        return view('familys.edit', ['family' => $family, 'intermediair'=>$intermediair, 'eigenaar'=>$eigenaar]);
    }


    public function update(Requests\CreateFamilyRequest $request)
    {
        $family = Family::findOrFail($request->id);

        $input = $request->all();

        $family->fill($input)->save();

        return redirect('family/show/'.$family->id)->with('message', 'Familiegegevens gewijzigd');
    }

    public function toggleok($id)
    {

        
        $loggedinuser = Auth::user();

        // Intermediairs mogen de activatie niet wijzigen        
        if(($loggedinuser->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $loggedinuser->id)->first();
            Log::info('Een intermediair probeerde de gezins-toggleaok te wijzigen, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if(($loggedinuser->usertype == 2)){
            
            Log::info('Een raadpleger probeerde de gezins-toggleaok te wijzigen, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $family = Family::find($id);

        if ($family->goedgekeurd==1) {

            /* 
            * Eerst de barcodes loskoppelen
            */
            $this->barcodesloskoppelen($family->id);

            $family->goedgekeurd=0;
            $family->save(); 
            
        } else {
            
            /* 
            * Eerst checken of er barcodes beschikbaar zijn
            */

            $barcodevoorraad = DB::select('select * from barcodes where kid_id IS NULL');

            if ($family->getKidscountAttribute() > count($barcodevoorraad)) {

                return redirect('gezinnenlijst/')->with('message', 'Er zijn maar ' . count($barcodevoorraad) . ' barcodes beschikbaar, terwijl dit gezin ' . $family->getKidscountAttribute() . ' kinderen heeft. Het gezin kan dus niet worden goedgekeurd, omdat er te weinig barcodes zijn. Vul de barcodes aan om verder te gaan.');

            } else {

            /* 
            * Er zijn voldoende barcodes beschikbaar. Koppel ze aan elk kind in dit gezin. 
            */
            $this->barcodeskoppelen($family->id); 

            $intermediair = $family->intermediair;

            $owner = $intermediair->user;

            /*
            *   stuur een mail naar de intermediair wanneer het gezin wordt afgekeurd. 
            */

            $maildata = [
                    'titel' => "Het gezin ". $family->achternaam. " is zojuist goedgekeurd",
                    'mailmessage' => "Het gezin " . $family->achternaam. " is zojuist goedgekeurd. Dit betekent dat (mits u niets meer wijzigt aan dit gezin) de kinderen verzekert zijn van een sinterklaaskado. \n\nNa sluiting van de inschrijving kunt u dan een PDF downloaden in uw downloadoverzicht. Een link naar dat overzicht ontvangt u als de inschrijvingen zijn gesloten.\n\nHeeft u hier vragen over? Neem dan contact op met info@sinterklaasbank.nl.",
                    'voornaam' => $owner->voornaam,
                    'email'=>$owner->email
            ];
            
            try{
                    Mail::send('emails.uitslagfamiliekeuren', $maildata, function ($message) use ($maildata){
                    $message->from('noreply@sinterklaasbank.nl', 'Stichting De Sinterklaasbank');
                    
                    $message->to($maildata['email']);
                        
                    $message->subject('Bericht van de Sinterklaasbank: ' . $maildata['titel']);
                });
            } 
            catch(\Exception $e){
                // catch code
            }


            /*
            *   Einde mail
            */

            $family->goedgekeurd=1;       
            $family->save();     
            }
      
        }
        


        return redirect('gezinnenlijst/')->with('message', 'Het gezin '. $family->achternaam. ' heeft een andere status gekregen.');

    }


    public function aanmelden($id)
    {
        
        $family = Family::findOrFail($id);
        $family->aangemeld=1;        
        $family->save();

        return redirect('intermediairs/show/'.$family->intermediair_id)->with('message', 'Het gezin '. $family->achternaam. ' is zojuist aangemeld. U ontvangt hiervan GEEN email ter bevestiging. U krijgt WEL automatisch een email als het gezin is beoordeeld door de Sinterklaasbank.');
    }    


    public function aanmeldingintrekken($id)
    {
        
        $family = Family::findOrFail($id);
        $family->aangemeld=0;    

        if ($family->goedgekeurd==1) {

            /* 
            * barcodes loskoppelen ()
            */

            $this->barcodesloskoppelen($family->id);

            $family->goedgekeurd=0;     
        }
             
        $family->save();
        
        return redirect('family/show/'.$family->id)->with('message', 'De aanmelding van het gezin '. $family->achternaam. ' is zojuist ingetrokken. U kunt nu wijzigen.');
    }   


    /* 
    * barcodes loskoppelen van de kinderen van dit gezin
    */

    public function barcodesloskoppelen($fam_id)
    {
      
        $family = Family::findOrFail($fam_id);

        foreach ($family->kids as $kid) {
            if (isset($kid->barcode->id)) {
                $barcode = Barcode::findOrFail($kid->barcode->id);
                $barcode->kid_id = NULL;
                $barcode->save();               
            }

        }
    }   


    /* 
    * barcodes koppelen aan de kinderen van dit gezin
    */

    public function barcodeskoppelen($fam_id)
    {
      
        $family = Family::findOrFail($fam_id);

        foreach ($family->kids as $kid) {

            $freebarcode = DB::select('select * from barcodes where kid_id IS NULL LIMIT 1');
            $barcode = Barcode::findOrFail($freebarcode[0]->id);
            $barcode->kid_id = $kid->id;
            $barcode->save();

        }
    }  


    /* 
    * Mogelijkheid om een gezin af te keuren door een tekst te zetten. 
    */

    public function afkeuren($fam_id)
    {

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


        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen eigen families bekijken 
        */        

      
        $family = Family::findOrFail($fam_id);
        return view('familys.afkeuren', ['family' => $family, 'settings'=>$settings_arr]);

    } 

    public function setafkeurtext(Request $request)
    {
      
        $family = Family::findOrFail($request->id);

        $family->redenafkeuren = $request->redenafkeuren;

        if ($request->definitiefafkeuren=="on") {
            $family->definitiefafkeuren = 1;
            $definitieftekst = "De afkeuring is definitief, u kunt het gezin niet opnieuw aanmelden. Wij verzoeken u het gezin uit uw lijst te verwijderen.";
        } else {
            $definitieftekst = "U kunt het gezin weer terugvinden in uw overzicht van gezinnen die niet zijn aangemeld, zodat u het gezin waar mogelijk kunt aanpassen of verwijderen.";
        }     

        $family->aangemeld = 0;
        $family->goedgekeurd = 0;
        
        $intermediair = $family->intermediair;

        $owner = $intermediair->user;


        /*
        *   stuur een mail naar de intermediair wanneer het gezin wordt afgekeurd. 
        */

        $maildata = [
                'titel' => "Het gezin ". $family->achternaam. " komt niet in aanmerking voor de Sinterklaasbank",
                'mailmessage' => "Het gezin " . $family->achternaam. " komt niet in aanmerking voor de Sinterklaasbank. De reden hiervoor is : \n\n " . $request->redenafkeuren . ".\n\n".$definitieftekst."\n\nHeeft u hier vragen over? Neem dan contact op met info@sinterklaasbank.nl.",
                'voornaam' => $owner->voornaam,
                'email'=>$owner->email
        ];
        
        try{
                 Mail::send('emails.uitslagfamiliekeuren', $maildata, function ($message) use ($maildata){
                    $message->from('noreply@sinterklaasbank.nl', 'Stichting De Sinterklaasbank');
                    
                    $message->to($maildata['email']);
                        
                    $message->subject('Bericht van de Sinterklaasbank: ' . $maildata['titel']);
                });   // try code
        } 
        catch(\Exception $e){
            // catch code
        }


        /*
        *   Einde mail
        */
        $this->barcodesloskoppelen($request->id);
        
        $family->save();

        return redirect('gezinnenlijst')->with('message', 'De aanmelding van het gezin '. $family->achternaam. ' is zojuist afgekeurd. De intermediair is op de hoogte gebracht.');
        
    }         

}
