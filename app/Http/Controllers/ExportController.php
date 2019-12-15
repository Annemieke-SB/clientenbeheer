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
use App\Exports\KidsExport;
use App\Exports\IntermediairsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
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
    	
        $lijst = array(
                        //  'Omschrijving' => 'selector'

                            'Goedgekeurde kinderen icm familie en intermediair'=>'kids',
                            'De intermediairs van goedgekeurde gezinnen'=>'intermediairs',

                    );       


        return view('exporteren.index', ['lijst'=>$lijst]);   

    }  




    public function exportselector($selector) 
    {
        

        // zie https://docs.laravel-excel.com/3.1/exports/ hoe de export kunnen worden klaargezet

        switch ($selector) {
            case "kids":
                return Excel::download(new KidsExport, 'kids.xlsx');
                break;
            case "intermediairs":
                return Excel::download(new IntermediairsExport, 'intermediairs.xlsx');
                break;
        }
    }

}
