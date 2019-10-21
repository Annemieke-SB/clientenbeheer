<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use DB;
use Route;
use App\User;
use App\Family;
use App\Kid;
use App\Setting;
use App\Barcode;


class MaillijstenController extends Controller
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

		if ($user->usertype != 1)
		{
		      return redirect('home');
		}
    	
        $lijst = array();       

            if (request()->input('lijst')=='zkg') { 
            // Zonder kinderen of gezinnen 

                $intermediairzonderfamilies = collect(User::where('usertype',3)
                    ->whereDoesntHave('familys')
                    ->select('email')
                    ->get()
                );

                $intermediairzonderkids = collect(User::where('usertype',3)
                    ->whereDoesntHave('kids')
                    ->whereHas('familys')
                    ->select('email')
                    ->get()
                );


                $samengevoegd = $intermediairzonderkids->merge($intermediairzonderfamilies);

                $lijst = $samengevoegd->unique();

            }
    

            if (request()->input('lijst')=='ntd') { 
            // Nog te downloaden

                $intermediairmetnietgedownloadepdfs = collect(User::whereHas('barcodes', function($query){
                            $query->whereNull('downloadedpdf');
                        })->select('email')->get()
                );

                $lijst = $intermediairmetnietgedownloadepdfs->unique();

            } 
/*
            if (request()->input('lijst')=='idpk') { 
            // Intermediairs die pdf krijgen

                $intermediairsdiepdfkrijgen = collect(User::whereHas('barcodes', function($query){
                            $query->whereNull('downloadedpdf');
                        })->select('email')->get()
                );

                $lijst = $intermediairsdiepdfkrijgen->unique();

            } 
*/
            if (request()->input('lijst')=='iag') { 
            // Intermediairs die nog gezinnen moeten aanmelden

                $intermediairmetnietaangemeldegezinnen = User::whereHas('familys', function($query){
                                //$query->where('aangemeld', 0);
                                $query->where('aangemeld', 0)->where('goedgekeurd', 0)->whereNull('familys.definitiefafkeuren');
                        })->get();


                $lijst = $intermediairmetnietaangemeldegezinnen->unique();

            }    

            if (request()->input('lijst')=='ai') { 
            // Alle intermediairs

                $alleintermediairs = collect(User::where('usertype',3)
                    ->select('email')
                    ->get()
                );


                $lijst = $alleintermediairs->unique();

            }  

            if (request()->input('lijst')=='aigg') { 
            // Alle intermediairs met goedgekeurde gezinnen

                $intermediairmetnietaangemeldegezinnen = User::whereHas('familys', function($query){
                                //$query->where('aangemeld', 0);
                                $query->where('goedgekeurd', 1);
                        })->get();


                $lijst = $alleintermediairs->unique();

            }  


        return view('maillijsten.index', ['lijst'=>$lijst]);   

    }  
}
