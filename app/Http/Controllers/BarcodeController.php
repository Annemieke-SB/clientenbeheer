<?php

namespace App\Http\Controllers;


use Input;
use Request;
use Excel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



use DB;
use App\Barcode;
use Config;
use App\Redeemed;
use App\Family;
use App\Kid;
use App\User;
use App\Setting;
use App\Intermediair;
use App\Intertoys;
use Custommade;


/* 
    Deze  heb  ik ertussen gezet omdat hij de cardnumber niet goed las
*/


use PHPExcel_Cell;
use PHPExcel_Cell_DataType;
use PHPExcel_Cell_IValueBinder;
use PHPExcel_Cell_DefaultValueBinder;

class MyValueBinder extends PHPExcel_Cell_DefaultValueBinder implements PHPExcel_Cell_IValueBinder
{
    public function bindValue(PHPExcel_Cell $cell, $value = null)
    {
        if (is_numeric($value))
        {
            $cell->setValueExplicit($value, PHPExcel_Cell_DataType::TYPE_STRING);

            return true;
        }
        
        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}


/* 
    Einde oplossing
*/





class BarcodeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Een intermediair probeerde de barcode-indexpagina te laden, userid: '.$user->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $aant_barcodes = DB::table('barcodes')->count(); //6000
        
        $beschikbare_barcodes = Barcode::where('kid_id', NULL)->count(); //987

        $losse_barcodes = Barcode::where('kid_id', '0')->count(); //6

        $uitgegeven_barcodes = $aant_barcodes - ($beschikbare_barcodes + $losse_barcodes);

        //$uitgegeven_barcodes = Barcode::whereNotNull('kid_id')->count();

        $nietgedownloadde_barcodes = Barcode::where('downloadedpdf', NULL)->count();

        $gedownloadde_barcodes = Barcode::whereNotNull('downloadedpdf', NULL)->count();    

					
		$aangemelde_kinderen = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
					->where('familys.aangemeld','=',1)
					->where('familys.goedgekeurd','=',0)
					->select('kids.*');
        })
        ->count();

	
		$niet_aangemelde_kinderen = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
					->where('familys.aangemeld','=',0)
					->whereNull('familys.definitiefafkeuren')
					->select('kids.*');
        })
        ->count();



        return view('barcodes.index', ['aant_barcodes' => $aant_barcodes, 'uitgegeven_barcodes' => $uitgegeven_barcodes, 'niet_aangemelde_kinderen' => $niet_aangemelde_kinderen, 'aangemelde_kinderen' => $aangemelde_kinderen, 'gedownloadde_barcodes'=>$gedownloadde_barcodes, 'losse_barcodes'=>$losse_barcodes]);
    }

    public function store()
    {

        $user = Auth::user();

        if(($user->usertype == 3)){

            Log::warning('Een intermediair probeerde de barcode-store-aktie te laden, userid: '.$user->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }


      
        /**
         *  hier wordt alles klaargezet om het format te controleren en de barcodes in een array te zetten
         */





        /**
        De code hiertussen is van het intertoys-tijdperk
         * ================================================


         *  alle ruwe barcodes worden gecheckt op een '=' teken, en daarna daarop ge-explode
         *  volgens Intertoys worden de barcodes namelijk is het volgende formaat aangeleverd;
         *
         -  6299930034000122453=49120000000000000,8109
         *  ^ ^ ^ barcode ^ ^ ^ 
         * 
        
                foreach ($raw_barcodes as $key => $value) {

                    if(preg_match("/\b=\b/i", $value[0])){

                        

                        $a = explode('=', $value[0]);     

                        $kandidaat= $a[0];                

                        //Controle of alle barcodes 19 cijfers hebben (geen letters of <> 19), anders wordt de vlag voor abort gehezen.
                        $c = Barcode::where('barcode', $kandidaat)->get();


                        if (!preg_match("/^[1-9][0-9]{18}$/", $kandidaat)) {
                            $no_19++;
                        } elseif (count($c)>0) {
                            $skipped[]= $kandidaat;
                        } else {              

                            $new_barcodes[] = $kandidaat;
                        }


                    } else {

                        $foutformaat = true; // als er geen '=' in de string zit worden er ook geen barcodes aangemaakt. 

                    }
                    
                }

        **/


/** 
* Barcodes checken en klaarzetten voor TOP1TOYS
*
**/

        /**
         * -- hier wordt de upload tijdelijk opgeslagen
         */

        $path = Storage::putFile('tmp', Request::file('uploadedfilename'));
      
        /**
         *  hier wordt de upload ingelezen
         */

        $raw_barcodes = Excel::load('storage/app/'.$path, function($reader) {})->noHeading()->get();

        /**
        *  variabelen
        */

        $skipped = array(); // Hier worden de barcodes opgeslagen die al in de db bestaan

        $new_barcodes = array();
        $aant_barcodes = 0;  
        $doubles = 0;  


        $no_19 = 0; // LEGACY VAN INTERTOYS, VOOR DE 19-CHECK IN DE BARCODE (OBSOLETE, DUS BLIJFT FALSE)
        $foutformaat = false; // LEGACY VAN INTERTOYS (OBSOLETE, DUS BLIJFT FALSE)

        foreach ($raw_barcodes as $key => $value) {

            $aant_barcodes++;

            // Barcode-kandidaat vaststellen

            $a = explode('=', $value[0]);     

            $kandidaat= $a[0];


            // Controle of de barcode al bestaat in de database

            $c = Barcode::where('barcode', $kandidaat)->get();

            if (count($c)>0) {

                $skipped[]= $kandidaat;

            } else {

                $new_barcodes[] = $kandidaat;

            }

        }




        /**
         *  Als alles bekeken is kan het bestand worden gewist uit de tmp-dir
         *  
         */
        
        Storage::delete($path);


        /**
         *  Foutafhandeling
         *  
         *  Als het vlaggetje is gehezen (geen 19 cijfers) of een lege array (geen '=') dan feedback teruggeven en niets toevoegen aan de database.
         *
         */

        if ($no_19 > 0 || $foutformaat || $aant_barcodes == 0 || count($skipped)>0) {

            return view('barcodes.afhandeling', ['no_19'=>$no_19, 'aant_barcodes'=>$aant_barcodes, 'doubles'=>$doubles, 'foutformaat'=>$foutformaat,'skipped'=>$skipped, 'errorvlag'=>true]);

        } else {

        /**
         *  Als alles goed is worden hier de barcodes toegevoegd aan de database
         *  
         */

            foreach ($new_barcodes as $barcode) {
                    
                $doubles = 0;

                /**
                * Het kan voorkomen dat de barcode niet in de database stond, maar wel dubbel in de lijst. Hier deze check.
                *
                **/

                $c = Barcode::where('barcode', $barcode)->get();
                if (count($c)>0) {

                    $doubles++;
                    // skip de rest

                } else {

                    /**
                    * Toevoegen aan database
                    *
                    **/                    

                    $b = new Barcode;
                    $b->barcode = $barcode;

                    try {
                      $b->save();
                    } catch(\Exception $e) {
                        dd($b);
                      return view('barcodes.afhandeling', ['no_19'=>$no_19, 'aant_barcodes'=>$aant_barcodes, 'doubles'=>$doubles, 'foutformaat'=>$foutformaat, 'skipped'=>$skipped, 'errorvlag'=>true]);
                    }     

                }                
            }

            return view('barcodes.afhandeling', ['no_19'=>$no_19, 'aant_barcodes'=>$aant_barcodes, 'doubles'=>$doubles, 'foutformaat'=>$foutformaat,'skipped'=>$skipped, 'errorvlag'=>false]);
        }
    }
    

    public function extrabarcodes()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde de extrabarcode-pagina te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $extrabarcodes = Barcode::where('kid_id', '=', '0')->get();

        return view('barcodes.extrabarcodes', ['extrabarcodes'=>$extrabarcodes]);  
    }

    
    public function barcodereview()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde een de barcodereview te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $nietgebruiktebarcodes = Barcode::where('value_of_redemptions', '=', 0)
                                ->whereNotNull('kid_id')
                                ->where('kid_id','!=',0)->get();

        $nietgebruiktelossebarcodes = Barcode::where('value_of_redemptions', '=', 0)
                                ->where('kid_id','=',0)->get();

        $totaaluitgegeven = Barcode::All()->sum('value_of_redemptions');
        //$totaaluitgegeven = 0;

        $welgebruiktebarcodes = Barcode::whereNotNull('value_of_redemptions')
                                ->whereNotNull('kid_id')->count();


        //$arrayIntermediairAantalOnverzilverdeBarcodes = Barcode::where('value_of_redemptions', '=', 0)

        $arrayIntermediairAantalOnverzilverdeBarcodes = User::whereHas('barcodes', function($query){
                $query->where('value_of_redemptions', 0)->where('kid_id','!=',0);
            })->orderBy('organisatienaam', 'ASC')->get(); 

        $overzichtIntermediairs = array();

        foreach ($arrayIntermediairAantalOnverzilverdeBarcodes as $key => $value) {
            $aantalOnverzilverd = Barcode::where('value_of_redemptions', '=', 0)
                                ->where('user_id','=',$value['id'])->count();
            $overzichtIntermediairs[] = [ 
                                        
                                        'id'=> $value['id'],
                                        'organisatienaam' => $value['organisatienaam'],
                                        'aantalonverzilverd' => $aantalOnverzilverd
                                        
                                    ];
        }

        return view('barcodes.nabeschouwing', ['nietgebruiktebarcodes'=>$nietgebruiktebarcodes,'nietgebruiktelossebarcodes'=>$nietgebruiktelossebarcodes, 'totaaluitgegeven'=>$totaaluitgegeven, 'welgebruiktebarcodes'=>$welgebruiktebarcodes, 
            'overzichtIntermediairs'=>$overzichtIntermediairs]);  
    }


    public function eindlijst_upload()
    {

        $user = Auth::user();

        if(($user->usertype == 3)){
            
            Log::warning('Een intermediair probeerde de eindlijst_upload te laden, userid: '.$user->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        /**
         * -- hier wordt de upload tijdelijk opgeslagen
         */

        $path = Storage::putFile('tmp', Request::file('uploadedfilename'));
      
        /**
         *  hier wordt de upload ingelezen
         */
        Config::set('excel.csv.delimiter', ';');
        //$raw_barcodes = Excel::load('storage/app/'.$path, function($reader) {})->get();


        $myValueBinder = new MyValueBinder;
        $raw_barcodes = Excel::setValueBinder($myValueBinder)->load('storage/app/'.$path)->get();


        /**
         *  hier wordt alles klaargezet om het format te controleren en de barcodes in een array te zetten
         */

        foreach ($raw_barcodes as $key => $value) {

                $barcodestring = str_replace(' ', '', $value['cardnumber']);

                $barcode = Barcode::where('barcode', $barcodestring)->update([
                    'value_of_redemptions' => str_replace(',', '.', $value['valueofredemptions']),
                ]);            
        }

        /**
         *  Als alles bekeken is kan het bestand worden gewist uit de tmp-dir
         *  
         */
        
        Storage::delete($path);

        return redirect()->action('BarcodeController@barcodereview');

    }


    public function claimlossebarcodes()
    {

        $user = Auth::user();

        if(($user->usertype == 3)){
            
            Log::warning('Een intermediair probeerde de claimlossebarcodes te laden, userid: '.$user->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $aantal = Request::input('aantal');
        $opmerking = Request::input('opmerking');


        $freebarcodes = Barcode::whereNull('kid_id')->take($aantal)->get();



        foreach ($freebarcodes as $freebarcode) {
            
                    Barcode::find($freebarcode->id)->update([
                    'kid_id' => 0,
                    'user_id' => $user->id,
                    'opmerking' => $opmerking,
                ]);  
        }

        return redirect()->action('BarcodeController@extrabarcodes');

    }


}
