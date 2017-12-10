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
use App\Redeemed;
use Custommade;


class RedeemedController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Een intermediair probeerde de redeemed-indexpagina te laden, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $redeemedcodes = DB::table('redeemed')->get();

        return view('redeemed.index', ['redeemedcodes' => $redeemedcodes]);
    }

}
