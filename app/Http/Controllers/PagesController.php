<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Http\Controllers\SettingsController;




class PagesController extends Controller
{
    $settings = SettingsController::getReadable();

    
    public function inschrijven()
    {
        if ($settings["inschrijven_gesloten"] == 1) {
            return view('inschrijvengesloten'); 
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
