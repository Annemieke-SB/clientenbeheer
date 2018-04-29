<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use DB;
use App\Family;
use App\Kid;
use App\Intertoys;
use App\Setting;

class KidController extends Controller
{


    public function index()
    {
        $kids = DB::table('kids')->get();

        return view('kids.index', ['kids' => $kids]);
    }

    public function show($id)
    {


        /*
        *
        * Settings leesbaar maken
        * Om deze in de view te krijgen: $settings['inschrijven_gesloten']
        *
        */

            $settings = Setting::all();
            $settings_arr=array();
            foreach ($settings as $setting) {
                $settings_arr[$setting->setting] = $setting->value;
            }

        /*
        * --
        */

        $kid = Kid::find($id);
        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $kid->user->id)){
            
            Log::info('Een intermediair probeerde een ander kind te bekijken (kid.show) te laden, userid: '.$loggedinuser->id);
            return redirect('user/show/'.$loggedinuser->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }


        return view('kids.show', ['kid' => $kid, 'settings'=>$settings_arr]);
    }  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //$family = DB::table('familys')->where('id', $id)->first();
	$family = Family::find($id);    
	return view('kids.create', ['family'=>$family]);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateKidRequest $request)
    {
        
        $family = DB::table('familys')->where('id', $request->input('family_id'))->first();


        Kid::create($request->all());

        return redirect('family/show/'.$family->id)->with('message', 'Kind toegevoegd');
    }

    public function destroy($id)
    {

        /* 
            Getest en werkt: 
            - intermediairs kunnen alleen eigen gezinnen deleten
            - Kinderen worden ook meteen gedelete  
            - raadplegers mogen niet wissen            
        */

        $kid = Kid::find($id);
        $loggedinuser = Auth::user();


        /*
        * Een intermediair kan een kind uit een aangemeld gezin niet wissen
        *
        */

        if ($kid->family->aangemeld == 1 && $loggedinuser->usertype == 3){

            Log::warning('Een intermediair probeerde de een kind uit een aangemeld gezin te verwijderen (kid.destroy), userid: '.$loggedinuser->id);
            return redirect('user/show/'.$loggedinuser->id)->with('message', 'U heeft een kind geprobeerd te wissen, maar het gezin is al aangemeld.');          
        }



        if(($loggedinuser->usertype == 2)){
            
            Log::info('Een raadpleger probeerde de een kind te verwijderen (kid.destroy), userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft iets geprobeerd te wissen, maar dat mag niet als raadpleger.');
        }

        // Intermediairs mogen geen andere familys deleten dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $kid->user->id)){
            
            Log::info('Een intermediair probeerde de een andere kind te verwijderen (kid.destroy), userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$loggedinuser->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        if($kid->barcode){
            $barcode = Barcode::findOrFail($kid->barcode->id);
            $barcode->kid_id = NULL;
            $barcode->save();       
        }

        Kid::destroy($id); // 1 way 
        return redirect('family/show/'.$kid->family->id)->with('message', 'Kind verwijderd');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kid = Kid::find($id);
        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $kid->user->id)){
            
            Log::info('Een intermediair probeerde een ander kind te wijzigen (kid.edit) te laden, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$loggedinuser->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
        

        return view('kids.edit', ['kid' => $kid]);
    }


    public function update(Requests\CreateKidRequest $request)
    {
        $kid = Kid::findOrFail($request->id);

        $input = $request->all();

        $kid->fill($input)->save();

        return redirect('kids/show/'.$kid->id)->with('message', 'Kindgegevens gewijzigd');
    }


   
}
