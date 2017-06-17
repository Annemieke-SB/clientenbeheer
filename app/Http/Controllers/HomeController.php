<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use App\Intermediair;
use App\Family;
use App\Kid;
use App\Setting;
use App\Barcode;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = Auth::user();

        /*
        *
        * Settings leesbaar maken
        * Om deze in de view te krijgen: $settings['inschrijven_gesloten']
        *
        */

            $settings = Setting::all();
            $settings_arr=array();
            foreach ($settings as $setting) {
                $settings_arr[$setting->setting] = $setting->value;
            }

        /*
        * --
        */
        

        $intermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();

        if($user->activated == 1 && $user->emailverified == 1) {


                if($user->usertype == 1){

                    $kids_disqualified = 0;
                    $families_disqualified = 0;
                    $kids_dubbel = 0;
                    $intermediairzonderfamilies = 0;
                    $familieszonderkinderen = 0;

                    $aangemelde_families = Family::where([['aangemeld', 1],['goedgekeurd', 0]])->get();

                    $kids = Kid::all();
                    $families = Family::all();
                    $intermediairs = Intermediair::all();

                    foreach ($kids as $kid) {
            
                        if ($kid->disqualified) {
                            $kids_disqualified++;
                        }

                        if ($kid->geboortedatumvoornaamdubbel){
                            $kids_dubbel++;
                        }

                    }

                    foreach ($families as $familie) {
            
                        if ($familie->disqualified) {
                            $families_disqualified++;
                        } 

                        if ($familie->kidscount == 0) {
                            $familieszonderkinderen++;
                        } 
                    }

                    foreach ($intermediairs as $intermediair) {            
                        if (!$intermediair->hasfams) {
                            $intermediairzonderfamilies++;
                        } 
                    }



                    return view('admin', ['kids_disqualified'=>$kids_disqualified, 'families_disqualified'=>$families_disqualified, 'kids_dubbel'=>$kids_dubbel, 'intermediairzonderfamilies'=>$intermediairzonderfamilies, 'familieszonderkinderen'=>$familieszonderkinderen, 'aangemelde_families'=>$aangemelde_families, 'settings'=>$settings_arr]);  



                }elseif($user->usertype == 2){
                    return view('raadpleger');
                }elseif($user->usertype == 3){
                    if ($intermediair) {
                        return redirect('intermediairs/show/'.$intermediair->id);
                    }
                    else {
                        return redirect('intermediairs/create/');
                    }
                    
                }   
        }
        elseif($user->emailverified == 0)  {

           return view('useremailnotverified'); 


        }else {
           return view('welcometempuser'); 
        }

        
    }

    public function docs()
    {
        return view('docs');        
    }

    public function inschrijven()
    {
        return view('inschrijven');        
    }    

    public function tellingen()
    {
        $kids_qualified = 0;
        $kids_disqualified = 0;

        $families_qualified = 0;
        $families_disqualified = 0;

        $intermediairs_totaal = 0;

        $kids = Kid::all();
        $families = Family::all();
        $intermediairs = Intermediair::all();

        foreach ($kids as $kid) {
            
            if ($kid->disqualified) {
                $kids_disqualified++;
            } else {
                $kids_qualified++;
            }
        }

        foreach ($families as $familie) {
            
            if ($familie->disqualified) {
                $families_disqualified++;
            } else {
                $families_qualified++;
            }
        }

        foreach ($intermediairs as $intermediair) {
            $intermediairs_totaal++;
        }


        return view('tellingen', ['kids_qualified'=>$kids_qualified, 'kids_disqualified'=>$kids_disqualified, 'families_qualified'=>$families_qualified, 'families_disqualified'=>$families_qualified, 'intermediairs_totaal'=>$intermediairs_totaal]);     
    }

    public function kinderlijst()
    {

        $kids = Kid::all();

        return view('kinderlijst', ['kids'=>$kids]);     
    }    

    public function gezinnenlijst()
    {

        $aangemelde_families = Family::where([['aangemeld', 1],['goedgekeurd', 0]])->get();
        $goedgekeurde_families = Family::where('goedgekeurd', 1)->get();
        $nietaangemelde_families = Family::where('aangemeld', 0)->get();

        return view('gezinnenlijst', ['goedgekeurdefamilies'=>$goedgekeurde_families,'aangemeldefamilies'=>$aangemelde_families, 'nietaangemeldefamilies'=>$nietaangemelde_families]);     
    }    



    public function emailtest()
    {

        $user = Auth::user();
        return view('emails.verification2', ['user'=>$user]);     
    }   
}