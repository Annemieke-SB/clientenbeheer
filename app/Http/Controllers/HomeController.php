<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DB;
use Route;
use App\User;
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
        

        

        if($user->activated == 1 && $user->emailverified == 1) {


                if($user->usertype == 1){

                    $kids_disqualified = 0;
                    $families_disqualified = 0;
                    $kids_dubbel = 0;
                    $intermediairzonderfamilies = User::whereDoesntHave('familys')->first();
                    $familieszonderkinderen = Family::whereDoesntHave('kids')->first();
                    $aangemelde_families = Family::where([['aangemeld', 1],['goedgekeurd', 0]])->count();

                    $kids = Kid::all();
                    $families = Family::all();
                    

                    foreach ($kids as $kid) {
            
                        if ($kid->disqualified) {
                            $kids_disqualified=1;
                            break;
                        }
                    }

                    foreach ($kids as $kid) {
            
                        if ($kid->geboortedatumvoornaamdubbel) {
                            $kids_dubbel=1;
                            break;
                        }
                    }


                    foreach ($families as $familie) {
                        if ($familie->disqualified) {
                            $families_disqualified++;
                            break;
                        } 
                    }




                    return view('admin', ['kids_disqualified'=>$kids_disqualified, 'families_disqualified'=>$families_disqualified, 'kids_dubbel'=>$kids_dubbel, 'intermediairzonderfamilies'=>$intermediairzonderfamilies, 'familieszonderkinderen'=>$familieszonderkinderen, 'aangemelde_families'=>$aangemelde_families, 'settings'=>$settings_arr]);  



                }elseif($user->usertype == 2){
                    return view('raadpleger');
                }elseif($user->usertype == 3){
                        return redirect('user/show/'.$user->id);
                }   
        }
        elseif($user->emailverified == 0)  {

            auth()->logout();
            return redirect('login')->with('message', 'U kunt nog niet inloggen omdat uw emailadres niet geverifieerd is. Klik alstublieft eerst op de link in de email.');  

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

        $kids = Kid::all();
        $families = Family::all();
        $intermediairs = User::where('usertype', 3);

        $kids_qualified = 0;
        $kids_disqualified = 0;
        $kids_metbarcode = 0;

        $families_totaal = 0;
        $families_qualified = 0;
        $families_disqualified = 0;
        $families_definitiefdisqualified = 0;

        $intermediairs_totaal = count($intermediairs);



        foreach ($kids as $kid) {

            if (isset($kid->barcode->id)){
                $kids_metbarcode++;
            }
            
           if ($kid->disqualified) {
                $kids_disqualified++;
            } else {
                $kids_qualified++;
            }
       }

        foreach ($families as $familie) {
            $families_totaal++;
            if ($familie->goedgekeurd == 0) {
                $families_disqualified++;
                if ($familie->definitiefafkeuren) {
                    $families_definitiefdisqualified++;
                }
            } else {
                if($familie->goedgekeurd == 1){
                    $families_qualified++;
                }
                
            }
        }
/*


        foreach ($intermediairs as $intermediair) {
            $intermediairs_totaal++;
        }
*/

        return view('tellingen', ['kids_qualified'=>$kids_qualified, 'kids_disqualified'=>$kids_disqualified, 'families_qualified'=>$families_qualified, 'families_disqualified'=>$families_disqualified, 'intermediairs_totaal'=>$intermediairs_totaal, 'families_definitiefdisqualified'=>$families_definitiefdisqualified, 'families_totaal'=>$families_totaal, 'kids_metbarcode'=>$kids_metbarcode]);     
    }

    public function kinderlijst()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde een de kinderlijst te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
        
       if (request()->has('gai')) { // geen andere alternatieven


            $kids = Kid::whereHas('family', function ($query) {
                $query->where('andere_alternatieven', '0');
            })->paginate(100)->appends('gai', request('gai'));

           
        } elseif (request()->has('wai')) { // wel andere alternatieven

            $kids = Kid::whereHas('family', function ($query) {
                $query->where('andere_alternatieven', '1');
            })->paginate(100)->appends('wai', request('wai'));

        } elseif (request()->has('gg')) { // goedgekeurde familie

            $kids = Kid::whereHas('family', function ($query) {
                $query->where('goedgekeurd', '1');
            })->paginate(100)->appends('gg', request('gg'));

        } elseif (request()->has('ngg')) { // niet goedgekeurde familie

            $kids = Kid::whereHas('family', function ($query) {
                $query->where('goedgekeurd', '0');
            })->paginate(100)->appends('ngg', request('ngg'));    

        } elseif (request()->has('p')) { // pdf gedownload

            $kids = Kid::whereHas('barcode', function ($query) {
                $query->where('downloadedpdf', '1');
            })->paginate(100)->appends('p', request('p'));   

        } elseif (request()->has('gp')) { // pdf niet gedownload

            $kids = Kid::whereHas('barcode', function ($query) {
                $query->where('downloadedpdf', NULL);
            })->paginate(100)->appends('ngg', request('ngg'));   

        } elseif (request()->has('achternaam')) { // achternaam

            $kids = Kid::whereHas('family', function ($query) {
                            $query->where('achternaam', 'like', "%" . request('achternaam') . "%");
                        })->paginate(100)->appends('achternaam', request('achternaam'));

        } else {

        
            $kids = Kid::orderBy('id', 'ASC')->paginate(100);
        }


        return view('kinderlijst', ['kids'=>$kids]);     
    }    

    public function extrabarcodes()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde een de kinderlijst te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $extrabarcodes = Barcode::where('kid_id', '=', '0')->get();

        return view('extrabarcodes', ['extrabarcodes'=>$extrabarcodes]);  
    }

    public function gezinnenlijst()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde een de kinderlijst te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        $aangemelde_families = Family::where([['aangemeld', 1],['goedgekeurd', 0]])->get();
        $goedgekeurde_families = Family::where('goedgekeurd', 1)->get();
        $nietaangemelde_families = Family::where('aangemeld', 0)->get();

        return view('gezinnenlijst', ['goedgekeurdefamilies'=>$goedgekeurde_families,'aangemeldefamilies'=>$aangemelde_families, 'nietaangemeldefamilies'=>$nietaangemelde_families]);     
    }    

    public function gezinnenlijst_goedgekeurd()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde een de kinderlijst te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if (request()->has('achternaam')) { // achternaam


                    $goedgekeurde_families = Family::where([
                            ['achternaam', 'like', "%" . request('achternaam') . "%"],
                            ['goedgekeurd', '1']
                        ])->paginate(100)->appends('achternaam', request('achternaam'));

                   
        } else {
                    $goedgekeurde_families = Family::where('goedgekeurd', 1)->paginate(100);
        }

        

        return view('gezinnenlijst_goedgekeurd', ['goedgekeurdefamilies'=>$goedgekeurde_families]);     
    }    


    public function gezinnenlijst_nogaantemelden()
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype!=1){ // als iemand anders dan admin wil kijken
            Log::info('Een niet-admin probeerde een de kinderlijst te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if (request()->has('achternaam')) { // achternaam


                    $nietaangemeldefamilies = Family::where([
                            ['achternaam', 'like', "%" . request('achternaam') . "%"],
                            ['goedgekeurd', '0']
                        ])->paginate(100)->appends('achternaam', request('achternaam'));

                   
        } elseif (request()->has('nda')) {
                    $nietaangemeldefamilies = Family::where([
                            ['definitiefafkeuren', NULL],
                            ['goedgekeurd', '0']
                        ])->paginate(100)->appends('nda', request('nda'));
        }


        else {
                    $nietaangemeldefamilies = Family::where('goedgekeurd', 0)->paginate(100);
        }

        

        return view('gezinnenlijst_nogaantemelden', ['nietaangemeldefamilies'=>$nietaangemeldefamilies]);     
    }     

    public function emailtest()
    {

        $user = Auth::user();
        return view('emails.verification2', ['user'=>$user]);     
    }   
}
