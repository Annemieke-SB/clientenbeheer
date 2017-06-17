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
use App\Family;
use App\Kid;
use App\User;
use App\Setting;
use App\Intermediair;
use App\Intertoys;
use App\Helpers\Custom;


class BarcodeController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Een intermediair probeerde de barcode-indexpagina te laden, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $aant_barcodes = DB::table('barcodes')->count();
        
        $beschikbare_barcodes = Barcode::where('kid_id', NULL)->count();

        $uitgegeven_barcodes = $aant_barcodes - $beschikbare_barcodes;

        $nietgedownloadde_barcodes = Barcode::where('downloadedpdf', NULL)->count();

        $gedownloadde_barcodes = $uitgegeven_barcodes - ($nietgedownloadde_barcodes - $beschikbare_barcodes);        

        $niet_aangemelde_families = Family::where('aangemeld', 0)->get();

        $aangemelde_families = Family::where(array('aangemeld'=> 1, 'goedgekeurd' => 0))->get();

        $niet_aangemelde_kinderen = 0;

        $aangemelde_kinderen = 0;

        foreach ($niet_aangemelde_families as $fam) {
            $niet_aangemelde_kinderen = $niet_aangemelde_kinderen + $fam->getKidscountAttribute();
        }

        foreach ($aangemelde_families as $fam) {
            $aangemelde_kinderen = $aangemelde_kinderen + $fam->getKidscountAttribute();
        }


        return view('barcodes.index', ['aant_barcodes' => $aant_barcodes, 'uitgegeven_barcodes' => $uitgegeven_barcodes, 'niet_aangemelde_kinderen' => $niet_aangemelde_kinderen, 'aangemelde_kinderen' => $aangemelde_kinderen, 'gedownloadde_barcodes'=>$gedownloadde_barcodes]);
    }

    public function store()
    {

        $user = Auth::user();

        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::warning('Een intermediair probeerde de barcode-store-aktie te laden, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        /**
         * -- hier wordt de upload tijdelijk opgeslagen
         */

        $path = Storage::putFile('tmp', Request::file('uploadedfilename'));
      
        /**
         *  hier wordt de upload ingelezen
         */

        $raw_barcodes = Excel::load('storage/app/'.$path, function($reader) {})->noHeading()->get();
      
        /**
         *  hier wordt alles klaargezet om het format te controleren en de barcodes in een array te zetten
         */

        $new_barcodes = array();
        $foutformaat = false;
        $aant_barcodes = 0;
        $no_19 = 0; // als een code niet precies 19 cijfers heeft, komt hier een +1 (dit is het vlaggetje of afwijkende formaten)
        $skipped = array(); // Hier worden de barcodes opgeslagen die al in de db bestaan


        /**
         *  alle ruwe barcodes worden gecheckt op een '=' teken, en daarna daarop ge-explode
         *  volgens Intertoys worden de barcodes namelijk is het volgende formaat aangeleverd;
         *
         -  6299930034000122453=49120000000000000,8109
         *  ^ ^ ^ barcode ^ ^ ^ 
         */

        
        foreach ($raw_barcodes as $key => $value) {

            if(preg_match("/\b=\b/i", $value[0])){

                $aant_barcodes++;

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

            return view('barcodes.afhandeling', ['no_19'=>$no_19, 'aant_barcodes'=>$aant_barcodes, 'foutformaat'=>$foutformaat,'skipped'=>$skipped, 'errorvlag'=>true]);

        } else {

        /**
         *  Als alles goed is worden hier de barcodes toegevoegd aan de database
         *  
         */



            foreach ($new_barcodes as $barcode) {


                    $b = new Barcode;
                    $b->barcode = $barcode;

                    try {
                      $b->save();
                    } catch(\Exception $e) {
                      return view('barcodes.afhandeling', ['no_19'=>$no_19, 'aant_barcodes'=>$aant_barcodes, 'foutformaat'=>$foutformaat, 'skipped'=>$skipped, 'errorvlag'=>true]);
                    }                   
                


                
            }


            return view('barcodes.afhandeling', ['no_19'=>$no_19, 'aant_barcodes'=>$aant_barcodes, 'foutformaat'=>$foutformaat,'skipped'=>$skipped, 'errorvlag'=>false]);

        }

    
    }
    






}
