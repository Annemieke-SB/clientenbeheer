<?php

namespace App\Http\Controllers;
use App\Faqs;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Mail\ChangeEmailVerification;
use App\Mail\EmailActivationtoggle;
use App\Family;
use App\Kid;
use App\User;
use App\Intertoys;
use App\Setting;
use App\Barcode;
use Mail;
use DB;
use Html;
use Custommade;



class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$faqs = Faqs::all();
        return view('faqs.index', ['faqs' => $faqs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loggedinuser = Auth::user();
        return view('faqs.create', ['user_id'=> $loggedinuser->id]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $id = Faqs::create($request->all())->id;

        return redirect('faq')->with('message', 'Vraag toegevoegd');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faqs $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
	{
		$f = Faqs::find($id);

        $loggedinuser = Auth::user();
        return view('faqs.edit', ['user_id'=> $loggedinuser->id, 'faq'=>$f]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faqs $faq)
    {
        $faq = Faqs::findOrFail($request->id);

        $input = $request->all();

        $faq->fill($input)->save();


        return redirect('faq')->with('message', 'Vraag gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    Faqs::destroy($id);
        return redirect('faq')->with('message', 'Vraag gewist');
    }
}
