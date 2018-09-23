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

            $users = User::where('activated', '0')->orderBy('achternaam', $sorts)->paginate($aant)->appends('filter', request('filter'));

        }

        return view('index', ['lijst'=>$lijst]);   





    }  
}
