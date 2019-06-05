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
use App\Intermediairtype;
use App\Kid;
use App\User;
use App\Intertoys;
use App\Setting;
use App\Barcode;
use Mail;
use DB;
use Html;
use Custommade;



class IntermediairtypeController extends Controller
{

    public function index()
    {
	$intermediairtypes = Intermediairtype::all();
        return view('intermediairtypes.index', ['intermediairtypes' => $intermediairtypes]);
    }


    public function create()
    {
        $loggedinuser = Auth::user();

        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde een intermediairtypes-create, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
        return view('intermediairtypes.create', ['user_id'=> $loggedinuser->id]);
        //
    }


    public function store(Request $request)
    {
        $loggedinuser = Auth::user();
        // Intermediairs mogen de index niet zien        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde een intermediairtypes-store, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
 
        $id = Intermediairtype::create($request->all())->id;

        return redirect('intermediairtypes')->with('message', 'intermediairtype toegevoegd');
        //
    }

    public function edit($id)
	{
        $loggedinuser = Auth::user();
        // Intermediairs mogen de index niet zien        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde een intermediairtypes-edit, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }        
		$f = Intermediairtype::find($id);

        $loggedinuser = Auth::user();
        return view('intermediairtypes.edit', ['user_id'=> $loggedinuser->id, 'intermediairtype'=>$f]);
        //
    }


    public function update(Request $request, Intermediairtype $intermediairtype)
    {
        $loggedinuser = Auth::user();
        // Intermediairs mogen de index niet zien        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde een intermediairtypes-edit, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
        $faq = Intermediairtype::findOrFail($request->id);

        $input = $request->all();

        $faq->fill($input)->save();


        return redirect('intermediairtypes')->with('message', 'Intermediairtype gewijzigd');
    }


    public function destroy($id)
    {
        $loggedinuser = Auth::user();
                // Intermediairs mogen de index niet zien        
        if(($loggedinuser->usertype == 3)){
            Log::info('Een intermediair probeerde een intermediairtype-destroy, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
	    Intermediairtype::destroy($id);
        return redirect('intermediairtypes')->with('message', 'Intermediairtype gewist');
    }
}
