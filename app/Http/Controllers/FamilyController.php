<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\User;
use App\Family;
use App\Kid;
use App\Barcode;
use App\Setting;
use Custommade;
use App\Blacklist;
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
            Getest en werkt: 
            - intermediairs kunnen alleen eigen families bekijken 
        */

        $loggedinuser = Auth::user();
        
        //$family = DB::table('familys')->where('id', $id)->first();
        $family = Family::find($id);

        //$eigenaar = DB::table('users')->where('id', $intermediair->user_id)->first();
        $min = Setting::get('min_leeftijd');
        $max = Setting::get('max_leeftijd');
        $maxbz = Setting::get('max_leeftijd_broer_zus');
        $g = Setting::get('inschrijven_gesloten');

        // Intermediairs mogen geen andere familys zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $family->user->id)){
            
            Log::info('Een intermediair probeerde de een andere familie te bekijken (family.show) te laden, userid: '.$loggedinuser->id);
            return redirect('user/show/'.$user->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }        

        return view('familys.show', ['family' => $family ]);
    }    



    public function create($id) // Dit ID is een intermediair-id
    {
       if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft geprobeerd iets te wijzigen terwijl de downloads al geopend zijn, dit kan niet. U bent weer teruggeleid naar uw startpagina.');
            
        }         

        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen families onder eigen ID toevoegen 
        */


        $user = User::find($id);
        $loggedinuser = Auth::user(); 
        //$intermediair_vanloggedinuser = DB::table('intermediairs')->where('user_id', $loggedinuser->id)->first();
     
        // Intermediairs mogen alleen familys aanmaken onder eigen id       
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $id)){            
            Log::info('Een intermediair probeerde de een familie aan te maken (family.create) bij een andere intermediair: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if(Setting::get('inschrijven_gesloten') == 1) {
            Log::info('Een intermediair probeerde de een familie aan te maken (family.create) terwijl de inschrijvingen zijn gesloten: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een gezin proberen aan te maken terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.');
        } else {
            return view('familys.create', ['user'=>$user]);
        }


        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateFamilyRequest $request)
    {

        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft geprobeerd iets te wijzigen terwijl de downloads al geopend zijn, dit kan niet. U bent weer teruggeleid naar uw startpagina.');
            
        } 
              
        if(Setting::get('inschrijven_gesloten') == 1) {

            Log::info('Een intermediair probeerde de een familie aan te maken (family.create) terwijl de inschrijvingen zijn gesloten: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een gezin proberen aan te maken terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.');

        } else {

            $id = Family::create($request->all())->id;
            return redirect('family/show/'.$id)->with('message', 'Familie toegevoegd');

        }
    }


    public function destroy($id)
    {
        $loggedinuser = Auth::user();
        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft geprobeerd iets te wijzigen terwijl de downloads al geopend zijn, dit kan niet. U bent weer teruggeleid naar uw startpagina.');
            
        } 

        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen eigen gezinnen deleten
            - Kinderen worden ook meteen gedelete  
            - raadplegers mogen niet wissen            
        */

        
        $family = Family::find($id);


        if (Setting::get('downloads_ingeschakeld') == 1) { // als downloads zijn ingeschakeld, dan kan er niets vernietigd worden
            return redirect('user/home'."/$family->user->id")->with('message', 'Het is niet mogelijk om gezinnen te verwijderen nadat de downloads zijn geopend. Dit omdat er mogelijk kinderen aan gekoppeld zitten die al een PDF tot hun beschikking hebben.'); 
        }



        /*
        * Een intermediair kan een kind uit een aangemeld gezin niet wissen
        *
        */

        if ($family->aangemeld == 1 && $loggedinuser->usertype == 3){

            Log::warning('Een intermediair probeerde een aangemeld gezin te verwijderen (family.destroy), userid: '.$loggedinuser->id);
            return redirect('user/show/'.$loggedinuser->id)->with('message', 'U heeft een gezin geprobeerd te wissen, maar het gezin is al aangemeld.');          
        }



        if(($loggedinuser->usertype == 2)){
            
            Log::info('Een raadpleger probeerde de een familie te verwijderen (family.destroy), userid: '.$loggedinuser->id);
            return redirect('user/show/'.$loggedinuser->id)->with('message', 'U heeft iets geprobeerd te wissen, maar dat mag niet als raadpleger.');
        }

        // Intermediairs mogen geen andere familys deleten dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $family->user->id)){
            
            Log::info('Een intermediair probeerde de een andere familie te verwijderen (family.destroy), userid: '.$loggedinuser->id);
            return redirect('user/show/'.$loggedinuser->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

	foreach($family->kids as $kid){

		if ($kid->barcode) {
			$barcode = $kid->barcode;
			$barcode->kid_id = null;
			$barcode->save();	
		}	
	}

        DB::table('kids')->where('family_id', '=', $id)->delete();
        Family::destroy($id); // 1 way 
        return redirect('user/show/'.$family->user->id)->with('message', 'Gezin verwijderd');
    }


    public function edit($id)
    {
        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft geprobeerd iets te wijzigen terwijl de downloads al geopend zijn, dit kan niet. U bent weer teruggeleid naar uw startpagina.');
            
        } 

        $family = Family::find($id);        
        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $family->user->id)){
            
            Log::info('Een intermediair probeerde een andere familie te wijzigen (family.edit) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if(Setting::get('inschrijven_gesloten') == 1) {

            Log::info('Een intermediair probeerde de een familie te wijzigen (family.edit) terwijl de inschrijvingen zijn gesloten: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een gezin proberen te wijzigen terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.');
            
        } 

        return view('familys.edit', ['family' => $family]);
        
    }


    public function update(Requests\CreateFamilyRequest $request)
    {
        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft geprobeerd iets te wijzigen terwijl de downloads al geopend zijn, dit kan niet. U bent weer teruggeleid naar uw startpagina.');
            
        } 

        if(Setting::get('inschrijven_gesloten') == 1) {

            Log::info('Een intermediair probeerde de een familie aan te maken (family.create) terwijl de inschrijvingen zijn gesloten: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een gezin proberen aan te maken terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.');
            
        } else {

            $family = Family::findOrFail($request->id);

            $input = $request->all();

            $family->fill($input)->save();

            return redirect('family/show/'.$family->id)->with('message', 'Familiegegevens gewijzigd');
        }
    }

    public function toggleok($id)
    {
        $loggedinuser = Auth::user();

        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een barcode geprobeerd los te koppelen terwijl de downloads al geopend zijn, dit kan niet omdat ze mogelijk al gedownload zijn. U bent weer teruggeleid naar uw startpagina.');
            
        } 

        

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

                return redirect('/family/show/' . $family->id)->with('message', 'Er zijn maar ' . count($barcodevoorraad) . ' barcodes beschikbaar, terwijl dit gezin ' . $family->getKidscountAttribute() . ' kinderen heeft. Het gezin kan dus niet worden goedgekeurd, omdat er te weinig barcodes zijn. Vul de barcodes aan om verder te gaan.');

            } else {

            /* 
            * Er zijn voldoende barcodes beschikbaar. Koppel ze aan elk kind in dit gezin. 
            */
            $this->barcodeskoppelen($family->id); 

            /*
            *   stuur een mail naar de intermediair wanneer het gezin wordt afgekeurd. 
            */

            $maildata = [
                    'titel' => "Het gezin ". $family->achternaam. " is zojuist goedgekeurd",
                    'mailmessage' => "Het gezin " . $family->achternaam. " is zojuist goedgekeurd. Dit betekent dat (mits u niets meer wijzigt aan dit gezin) de kinderen verzekert zijn van een sinterklaaskado. \n\nNa sluiting van de inschrijving kunt u dan een PDF downloaden in uw downloadoverzicht. Een link naar dat overzicht ontvangt u als de inschrijvingen zijn gesloten.\n\nHeeft u hier vragen over? Neem dan contact op met info@sinterklaasbank.nl.",
                    'voornaam' => $family->user->voornaam,
                    'email'=>$family->user->email
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
        


        return redirect('family/show/' . $family->id)->with('message', 'Het gezin '. $family->achternaam. ' heeft een andere status gekregen.');

    }


    public function aanmelden($id)
    {
        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes  te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een barcode geprobeerd te koppelen terwijl de downloads al geopend zijn, dit kan niet. U bent weer teruggeleid naar uw startpagina.');
            
        } 
        
        $family = Family::findOrFail($id);
        $family->aangemeld=1;        
        $family->save();

        return redirect('user/show/'.$family->user->id)->with('message', 'Het gezin '. $family->naam. ' is zojuist aangemeld. U ontvangt hiervan GEEN email ter bevestiging. U krijgt WEL automatisch een email als het gezin is beoordeeld door de Sinterklaasbank.');
    }    


    public function aanmeldingintrekken($id)
    {
        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een barcode geprobeerd los te koppelen terwijl de downloads al geopend zijn, dit kan niet omdat ze mogelijk al gedownload zijn. U bent weer teruggeleid naar uw startpagina.');
            
        } 

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


        if(Setting::get('downloads_ingeschakeld') == 1) {

            Log::info('Er werd geprobeerd barcodes los te koppelen terwijl de downloads al zijn geopend: user '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een barcode geprobeerd los te koppelen terwijl de downloads al geopend zijn, dit kan niet omdat ze mogelijk al gedownload zijn. U bent weer teruggeleid naar uw startpagina.');
            
        } 

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
            Getest en werkt: 
            - intermediairs kunnen alleen eigen families bekijken 
        */        

      
        $family = Family::findOrFail($fam_id);
        return view('familys.afkeuren', ['family' => $family]);

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
        
        $owner = $family->user;


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

        return redirect('family/show/' . $family->id)->with('message', 'De aanmelding van het gezin '. $family->achternaam. ' is zojuist afgekeurd. De intermediair is op de hoogte gebracht.');
        
    }         

}
