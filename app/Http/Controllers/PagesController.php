<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Setting;



class PagesController extends Controller
{

    public function inschrijven()
    {
        return view('inschrijven');        
    }    

}
