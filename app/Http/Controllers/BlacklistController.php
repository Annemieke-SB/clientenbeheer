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
use App\Blacklist;
use App\User;
use App\Intertoys;
use App\Setting;
use App\Barcode;
use Mail;
use DB;
use Html;
use Custommade;



class BlacklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$items = Blacklist::all();
        return view('blacklist.index', ['blacklisted_items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Blacklist $request)
    {
        $loggedinuser = Auth::user();
     


        return view('blacklist.create', ['user_id'=> $loggedinuser->id]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Blacklist $blacklist_item)
    {
     
         $this->validate($request, [
                'email' => 'required|unique:blacklist|email',
                'reden' => 'required',
        ]);


 

        $id = Blacklist::create($request->all())->id;

        return redirect('blacklist')->with('message', 'Item toegevoegd');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Blacklist $blacklist)
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
		$f = Blacklist::find($id);

        $loggedinuser = Auth::user();
        return view('blacklist.edit', ['user_id'=> $loggedinuser->id, 'item'=>$f]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blacklist $blacklist_item)
    {
        $blacklist_item = Blacklist::findOrFail($request->id);




        $this->validate($request, [
                'email' => 'required|unique:blacklist|email',
                'reden' => 'required',
        ]);

        $input = $request->all();

        $blacklist_item->fill($input)->save();


        return redirect('blacklist')->with('message', 'Item gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    Blacklist::destroy($id);
        return redirect('blacklist')->with('message', 'Item gewist');
    }
}
