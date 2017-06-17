<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;


class ContactController extends Controller
{
    public function index()
    {
    	$contacts = DB::table('contacts')->get();
        return view('contacts.index', ['contacts' => $contacts]);
    }

    public function show($id)
    {
		$contact = DB::table('contacts')->where('id', $id)->first();
        return view('contacts.show', ['contact' => $contact]);
    }    



    public function edit($id)
    {
        $contact = DB::table('contacts')->where('id', $id)->first();
        return view('contacts.edit', ['contact' => $contact]);
    }
}
