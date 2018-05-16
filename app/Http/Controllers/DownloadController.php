<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use PDF;
use App\Family;
use App\Barcode;
use App\Kid;
use App\User;
use App\Setting;
use App\Intermediair;
use App\Intertoys;
use Custommade;

class DownloadController extends Controller
{


    /*
    * DOWNLOAD PDF VOOR KIND
    *
    * Barcodefetcher zorgt voor de juiste view tijdens de dowload, verdere afhandeling van de download
    * gebeurd in pdfvoorkind. 
    *
    * checkmatch controleert of een kind wel bij de intermediair hoort. Zo niet wordt een logvermelding aangemaakt. 
    *
    */

    private function checkmatch($id) {
        $kid = Kid::find($id);
        $loggedinuser = Auth::user();

        if ($kid->user->id == $loggedinuser->id) {
            return true;
        }
        else {
            Log::emergency('Door gebruiker ID: '.$loggedinuser->id . ' werd gepoogd een barcode van een ander kind te downloaden');
            return false;
        }
    }

    public function barcodefetcher($id) {

        $match = $this->checkmatch($id);

        $meta = '<meta http-equiv="refresh" content="5;URL=\''.url('/download/pdfvoorkind').'/'.$id.'\'">';

        return view('downloads.barcodefetcher',['meta'=>$meta, 'id'=>$id, 'match'=>$match]);
    }


    public function pdfvoorkind($id) {

        $match = $this->checkmatch($id);

        if ($match) {
            $kid = Kid::find($id);    
            $kid->downloadedbarcodepdf = 1;  

            $pdf = PDF::loadView('pdf.kind', ['kid' => $kid]);
            return $pdf->download(ucfirst($kid->voornaam) . ' ' . ucfirst($kid->achternaam) . '-' .date('ymdhis') . '.pdf');      
        }

    }

    public function extrapdf($id) {


            $barcode = Barcode::find($id);    
            $barcode->downloadedpdf = 1;


            $pdf = PDF::loadView('pdf.extrapdf', ['barcode' => $barcode]);
            $barcode->save();  
            return $pdf->download('Extra Barcode Sinterklaasbank-' .date('ymdhis') . '.pdf');      
        

    }


}
