<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;

use DB;
use Html;
use App\Intertoys;


class IntertoyController extends Controller
{

    public function get()
    {
        $Intertoys = DB::table('Intertoys')->where('id', $id)->first();
        $familys = Intertoys::find($id)->familys;
        
        
        return view('Intertoys.show', ['Intertoys' => $Intertoys, 'familys' => $familys);
    }    


}
