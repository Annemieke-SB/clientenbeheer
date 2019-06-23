<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Events\AdminHomePageEvent;
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

        if($user->activated == 0 && $user->emailverified == 1) {

            return view('welcometempuser'); 

        }

		if($user->activated == 1 && $user->emailverified == 1) {

    		if($user->usertype == 1)
    		{

    		/**
    		 * Hier komt de admin-pagina
    		 */

            //dd(Setting::find(5)->setting); 
/*

                    $intermediairzonderfamilies = Cache::pull('intermediairzonderfamilies');
                    $familieszonderkinderen = Cache::store('database')->get('familieszonderkinderen');
                    $nogtekeuren_families = Cache::store('database')->get('nogtekeuren_families');
                    $nogtekeuren_users = Cache::store('database')->get('nogtekeuren_users');
                    $intermediairmetnietgedownloadepdfs = Cache::store('database')->get('intermediairmetnietgedownloadepdfs');
*/

if (Cache::has('nogtekeuren_families')) {
    dd(Cache::store('database')->get('nogtekeuren_families'));
}

                    $intermediairzonderfamilies = Cache::remember('intermediairzonderfamilies', 300, function () {
                        return User::where('usertype',3)->whereDoesntHave('familys')->where('activated', 1)->get();
                    });
                    $familieszonderkinderen = Cache::remember('familieszonderkinderen', 300, function () {
                        return Family::whereDoesntHave('kids')->get();
                    });
                    $nogtekeuren_families = Cache::remember('nogtekeuren_families', 300, function () {
                        return Family::where([['aangemeld', 1],['goedgekeurd', 0]])->get();
                    });
                    $nogtekeuren_users = Cache::remember('nogtekeuren_users', 300, function () {
                        return User::where([['activated', 0],['emailverified', 1]])->get();
                    });
                    $intermediairmetnietgedownloadepdfs = Cache::remember('intermediairmetnietgedownloadepdfs', 300, function () {
                        return User::whereHas('barcodes', function($query){
                            $query->whereNull('downloadedpdf');
                        })->get();
                    });




                    event(new AdminHomePageEvent());      
    	    
                    return view('admin', ['nogtekeuren_users'=>$nogtekeuren_users, 'intermediairzonderfamilies'=>$intermediairzonderfamilies, 'familieszonderkinderen'=>$familieszonderkinderen, 'nogtekeuren_families'=>$nogtekeuren_families, 'intermediairmetnietgedownloadepdfs'=>$intermediairmetnietgedownloadepdfs]);  

    		}
    		elseif($user->usertype == 2)
    		{
    	
    		/**
    		 * Hier komt de admin-pagina
    		 */
    	    
    			return view('raadpleger');
    		
    		}
    		elseif($user->usertype == 3)
    		{
    	
    		/**
    		 * Hier komt de intermediair-pagina
    		 */
    	
    			return redirect('user/show/'.$user->id);
    		
    		}   
        } elseif($user->emailverified == 0)  {

                auth()->logout();
                return redirect('login')->with('message', 'U kunt nog niet inloggen omdat uw emailadres niet geverifieerd is. Klik alstublieft eerst op de link in de email.');  
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

        $kids = Kid::all()->count();
        $families = Family::all()->count();
        $intermediairs = User::where('usertype', 3)->count();
	
		$intermediairzonderfamilies = User::where('usertype',3)->whereDoesntHave('familys')->count();
		$intermediairzonderkids = User::where('usertype',3)->whereDoesntHave('kids')->whereHas('familys')->count();

		
		$kids_disqualified = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
					->whereNotNull('familys.redenafkeuren')
					->where('familys.goedgekeurd','=',0)
					->whereNull('familys.definitiefafkeuren')
                    ->where('familys.aangemeld','=',0)
					->select('kids.*');
        })
        ->count();
	
		$kids_definitiefdisqualified = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
					->whereNotNull('familys.definitiefafkeuren')
					->select('kids.*');
        })
        ->count();
		
		$kids_goedgekeurd = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
					->where('familys.goedgekeurd','=',1)
					->select('kids.*');
        })
        ->count();

        $kids_metbarcode = Barcode::whereNotNull('kid_id')->count();

  
        $gezinnen_nog_niet_aangemeld = Family::where('goedgekeurd','=',0)
                ->where('aangemeld','=',0)
                ->whereNull('definitiefafkeuren')
                ->select('familys.*')
                ->count();    

        $familieszonderkinderen = Family::whereDoesntHave('kids')->count();  

        $families_disqualified = Family::whereNotNull('redenafkeuren')
                ->where('goedgekeurd','=',0)
                ->whereNull('definitiefafkeuren')
                ->select('familys.*')
                ->count();        

        $families_definitiefdisqualified = Family::whereNotNull('definitiefafkeuren')->count();
        
		$families_goedgekeurd = Family::where('goedgekeurd','=',1)
				->count();

        $families_tekeuren = Family::where('goedgekeurd','=',0)
                            ->where('aangemeld','=',1)
                            ->count();


        $kids_nog_niet_aangemeld = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
                    ->where('familys.goedgekeurd','=',0)
                    ->where('familys.aangemeld','=',0)
                    ->whereNull('familys.redenafkeuren')
                    ->whereNull('familys.definitiefafkeuren')
                    ->select('kids.*');
        })
        ->count();

        $kids_in_afwachting_van_keuring = DB::table('kids')
        ->join('familys', function ($Join) {
            $Join->on('kids.family_id', '=', 'familys.id')
                    ->where('familys.goedgekeurd','=',0)
                    ->where('familys.aangemeld','=',1)
                    ->whereNull('familys.definitiefafkeuren')
                    ->select('kids.*');
        })
        ->count();



		return view('tellingen', ['intermediairzonderfamilies'=>$intermediairzonderfamilies, 'intermediairzonderkids'=>$intermediairzonderkids,
				'families_goedgekeurd'=>$families_goedgekeurd, 'familieszonderkinderen'=>$familieszonderkinderen, 'families_tekeuren'=>$families_tekeuren, 'kids'=>$kids,'kids_goedgekeurd'=>$kids_goedgekeurd, 'kids_definitiefdisqualified'=>$kids_definitiefdisqualified, 'kids_disqualified'=>$kids_disqualified, 'families_disqualified'=>$families_disqualified, 'intermediairs'=>$intermediairs, 'families_definitiefdisqualified'=>$families_definitiefdisqualified, 'families'=>$families, 'kids_metbarcode'=>$kids_metbarcode, 'kids_in_afwachting_van_keuring' => $kids_in_afwachting_van_keuring, 'kids_nog_niet_aangemeld'=> $kids_nog_niet_aangemeld, 'gezinnen_nog_niet_aangemeld'=>$gezinnen_nog_niet_aangemeld]);     
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
