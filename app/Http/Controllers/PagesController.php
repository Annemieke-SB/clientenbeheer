<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Setting;
//use App\Http\Controllers\SettingsController as Settings;



class PagesController extends Controller
{
    

    public function inschrijven()
    {   
        if (Setting::get("inschrijven_gesloten") == 1) {
            return view('inschrijvinggesloten'); 
        } else {
            return view('inschrijven'); 
        }
               
    }  

    public function particulier()
    {
        return view('particulier');        
    }       

    public function voorwaarden()
    {
        return view('voorwaarden');        
    }   

    public function home()
    {
        return redirect('home');    
    }   

    public function test()
    {
        return view('test.test');    
    }   
}
