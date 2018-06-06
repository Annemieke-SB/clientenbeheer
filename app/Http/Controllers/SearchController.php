<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\Setting;
use Mail;
use App\Intermediair;
use App\User;
use Custommade;
use App\Family;
use App\Kid;

class SearchController extends Controller
{
   	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Intermediairs mogen de index niet zien        
        if(($user->usertype == 3)){
            Log::info('Een intermediair probeerde de settings-indexpagina te laden, userid: '.$user->id);
            return redirect('user/show/'.$user->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

	$q = $request->q; // zoekopdracht
	
	if ($q=='') {
		return back();
	}

	$users = User::where(
		'email', 'like', '%' . $q . '%')
		->orWhere('achternaam', 'like', '%' . $q . '%')
		->orWhere('voornaam', 'like', '%' . $q . '%')
		->orWhere('postcode', 'like', '%' . $q . '%')
		->orWhere('woonplaats', 'like', '%' . $q . '%')
		->get();		

	$kids = Kid::where(
		'achternaam', 'like', '%' . $q . '%')
		->orWhere('voornaam', 'like', '%' . $q . '%')
		->get();		


	$familys = Family::where(
		'email', 'like', '%' . $q . '%')
		->orWhere('achternaam', 'like', '%' . $q . '%')
		->orWhere('postcode', 'like', '%' . $q . '%')
		->orWhere('woonplaats', 'like', '%' . $q . '%')
		->get();		

	$organisaties = User::where(
		'organisatienaam', 'like', '%' . $q . '%')
		->get();		

	return view('search.index', ['organisaties'=>$organisaties, 'users' => $users, 'familys'=>$familys, 'kids'=>$kids, 'q'=>$q]);
    }
  

}
