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
        return view('inschrijvinggesloten');        
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

}
