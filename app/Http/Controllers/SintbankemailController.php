<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class SintbankemailController extends Controller
{

	public function getEmailById($id)
    {
        $sintbankemail = DB::table('sintbankemails')->where('id', $id)->first();
        return $sintbankemail->sintbankemail;
    }

    public function index()
    {
        $sintbankemails = DB::table('sintbankemails')->get();

        return view('sintbankemails.index', ['sintbankemails' => $sintbankemails]);
    }
}
