<?php

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\Model;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Family;
use App\Kid;
use App\User;
use App\Intertoys;
use App\Setting;
use App\Barcode;
use DB;
use Html;
use Custommade;
use App\Intermediair;


class IntermediairController extends Controller
{

    public function index(Request $request)
    {

        if (request()->has('naam')) {

            $intermediairs = Intermediair::whereHas('user', function ($query) {
                            $query->where('organisatienaam', 'like', "%" . request('naam') . "%");
                        })->paginate(50)->appends('naam', request('naam'));
            
        } else {
            $intermediairs = Intermediair::with('user')->orderBy('id', 'DESC')->paginate(50);
        }

        

        $user = Auth::user();

        // Intermediairs mogen de index niet zien        
        if(($user->usertype == 3)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Een intermediair probeerde de intermediair-indexpagina te laden, userid: '.$user->id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

        return view('intermediairs.index', ['intermediairs' => $intermediairs]);
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


        $intermediair = Intermediair::find($id);
        
        //$intermediair = DB::table('intermediairs')->where('id', $id)->first();
        $eigenaar = DB::table('users')->where('id', $intermediair->user_id)->first();
        $user = Auth::user();
        
        // Als de url wordt aangepast door een intermediair dan terugzetten naar juiste pagina en een log-vermelding maken.
        
        if(($user->usertype == 3) && ($user->id != $intermediair->user_id)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Bij intermediair->show werd een foute ID gekozen door de ingelogde gebruiker met het ID: '.$user->id . '. Er werd gepoogd intermediair_id te bekijken met ID: '.$id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }   
        
        
        $familys = Intermediair::find($id)->familys;
        $aangemelde_families = Family::where([
                ['aangemeld', '=', '1'],
                ['goedgekeurd', '=', '0'],
                ['intermediair_id', '=', $id],
            ])->get();

        $nietaangemelde_families = Family::where([
                ['aangemeld', '=', '0'],
                ['intermediair_id', '=', $id],
            ])->get();

        $goedgekeurde_families = Family::where([
                ['goedgekeurd', '=', '1'],
                ['intermediair_id', '=', $id],
            ])->get();

        $afgekeurde_families = Family::where([
                ['redenafkeuren', '!=', ''],
                ['goedgekeurd', '=', '0'],
                ['aangemeld', '=', '0'],
                ['intermediair_id', '=', $id],
            ])->get();

        //$nietaangemelde_families = Family::where('aangemeld', 0)->get();
       
        return view('intermediairs.show', ['intermediair' => $intermediair, 'familys' => $familys, 'aangemelde_families' => $aangemelde_families,'nietaangemelde_families' => $nietaangemelde_families,'afgekeurde_families' => $afgekeurde_families,'goedgekeurde_families' => $goedgekeurde_families, 'eigenaar' => $eigenaar, 'settings'=>$settings_arr]);
    }    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        // Als een raadpleger een intermediair wil aanmaken, dan terugzetten naar juiste pagina en een log-vermelding maken.
        
        if(($user->usertype == 2)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Intermediair->create werd door een raadpleger met het ID: '.$user->id . ' opgeroepen.');
            return redirect('/home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }
        return view('intermediairs.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateIntermediairRequest $request)
    {

        $new = Intermediair::create($request->all());

        return redirect('intermediairs/show/'.$new->id)->with('message', 'Instelling toegevoegd');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $intermediair = Intermediair::find($id);
        
        $eigenaar = DB::table('users')->where('id', $intermediair->user_id)->first();
        $loggedinuser = Auth::user();

        // Intermediairs mogen geen andere kinderen zien dan diegene die ze zelf beheren        
        if(($loggedinuser->usertype == 3)&&($loggedinuser->id != $intermediair->user_id)){
            
            Log::info('Een intermediair probeerde een andere familie te wijzigen (family.edit) te laden, userid: '.$loggedinuser->id);
            return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }


        return view('intermediairs.edit', ['intermediair'=>$intermediair, 'eigenaar'=>$eigenaar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateIntermediairRequest $request)
    {
        $intermediair = Intermediair::findOrFail($request->id);

        $input = $request->all();

        $intermediair->fill($input)->save();

        return redirect('intermediairs/show/'.$intermediair->id)->with('message', 'Intermediairgegevens gewijzigd');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $loggedinuser = Auth::user();

        if ($loggedinuser->usertype==1){

                $intermediair = Intermediair::findOrFail($id);

                $familys = Family::where('intermediair_id', '=', $intermediair->id)->get(); 


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
                


                if ($settings_arr['inschrijven_gesloten'] == 1) { // als inschrijven is gesloten, dan kan er niets vernietigd worden
                    return redirect('intermediairs')->with('message', 'Het is niet mogelijk om gezinnen te verwijderen nadat de inschrijvingen zijn gesloten. Dit omdat er mogelijk kinderen aan gekoppeld zitten die al een PDF tot hun beschikking hebben. Je zou wel de gebruiker (intermediair) kunnen deactiveren in het gebruikersoverzicht.'); 
                }

                    foreach($familys as $family) {



                            /* 
                            * Routine om de evt barcodes los te koppelen
                            *
                            */
                            //$kids = DB::table('kids')->where('family_id', '=', $family->id)->get();
                            $kids = Kid::where('family_id', '=', $family->id)->get(); 
                            
                            foreach ($kids as $kid) {

                                if ($kid->barcode) {
                                    $barcode = Barcode::findOrFail($kid->barcode->id);
                                    $barcode->kid_id = NULL;
                                    $barcode->save();                                  
                                }
                                    

                            }

                            /*
                            * Einde barcode routine
                            */



                        DB::table('kids')->where('family_id', '=', $family->id)->delete();
                    } 
                    DB::table('familys')->where('intermediair_id', '=', $intermediair->id)->delete();
                Intermediair::destroy($id); // 1 way 
                return redirect('intermediairs')->with('message', 'Intermediair, inclusief onderliggende families en kinderen, verwijderd');          
        } else 
        {
            Log::info('Een niet-admin probeerde een intermediair te verwijderen (intermediair.destroy) te laden, userid: '.$loggedinuser->id);
            return redirect('home')->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }

    }


    public function gezinsoverzicht($id)
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

        $intermediair = Intermediair::find($id);
        
        //$intermediair = DB::table('intermediairs')->where('id', $id)->first();
        $eigenaar = DB::table('users')->where('id', $intermediair->user_id)->first();
        $user = Auth::user();
        
        // Als de url wordt aangepast door een intermediair dan terugzetten naar juiste pagina en een log-vermelding maken.
        
        if(($user->usertype == 3) && ($user->id != $intermediair->user_id)){
            $juisteintermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();
            Log::info('Bij intermediair->gezinsoverzicht werd een foute ID gekozen door de ingelogde gebruiker met het ID: '.$user->id . '. Er werd gepoogd intermediair_id te bekijken met ID: '.$id);
            return redirect('intermediairs/show/'.$juisteintermediair->id)->with('message', 'U heeft een onjuiste pagina bezocht en bent weer teruggeleid naar uw startpagina.');
        }   
        
        //$familys = Intermediair::find($id)->familys;
        $familys = Intermediair::find($id)->familys;
        $aangemelde_families = Family::where([
                ['aangemeld', '=', '1'],
                ['goedgekeurd', '=', '0'],
                ['intermediair_id', '=', $id],
            ])->get();

        $nietaangemelde_families = Family::where([
                ['aangemeld', '=', '0'],
                ['intermediair_id', '=', $id],
            ])->get();

        $goedgekeurde_families = Family::where([
                ['goedgekeurd', '=', '1'],
                ['intermediair_id', '=', $id],
            ])->get();
        //$nietaangemelde_families = Family::where('aangemeld', 0)->get();
       
        return view('intermediairs.gezinsoverzicht', ['intermediair' => $intermediair, 'familys' => $familys, 'aangemelde_families' => $aangemelde_families,'nietaangemelde_families' => $nietaangemelde_families,'goedgekeurde_families' => $goedgekeurde_families, 'eigenaar' => $eigenaar, 'settings'=>$settings_arr]);
    }        


    public function downloads()
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


        $user = Auth::user();
        $intermediair = DB::table('intermediairs')->where('user_id', $user->id)->first();


        // Intermediairs mogen de downloadpagina zien        
        if((!$user->usertype == 3)){
            return redirect('intermediairs')->with('message', 'Alleen een intermediair kan deze pagina zien.');
        } 

        $goedgekeurde_families = Family::where([
                ['goedgekeurd', '=', '1'],
                ['intermediair_id', '=', $intermediair->id],
            ])->with('kids')->get();


        return view('intermediairs.downloads', ['families' => $goedgekeurde_families, 'settings'=>$settings_arr]);
    }



}
