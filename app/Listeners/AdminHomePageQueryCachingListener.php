<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use App\User;
use DB;
use App\Family;
use App\Kid;
use App\Barcode;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Events\AdminHomePageEvent;
use Illuminate\Support\Facades\Log;


class AdminHomePageQueryCachingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SomeEvent  $event
     * @return void
     */
    public function handle()
    {

        // Oude cache is al in de HomeController geleegd. 

                    

        // Nieuwe cache aanleggen

        // HELAAS WORDEN NIET ALLE ONDERSTAANDE PUNTEN GECACHED, KENNELIJK IS HET NIET MOGELIJK RELATIES TE CACHEN
        /*
                    Cache::rememberForever('intermediairzonderfamilies', function () { // deze wordt niet gecached
                        return User::where('usertype',3)->whereDoesntHave('familys')->where('activated', 1)->get();
                    });

                    Cache::rememberForever('familieszonderkinderen', function () { // deze wordt niet gecached
                        return Family::whereDoesntHave('kids')->get();
                    });

                    Cache::rememberForever('intermediairmetnietgedownloadepdfs', function () { // deze wordt niet gecached
                        return User::whereHas('barcodes', function($query){
                            $query->whereNull('downloadedpdf');
                        })->get();
                    });

        */
                    
                    Cache::rememberForever('nogtekeuren_families', function () {
                        return Family::where([['aangemeld', 1],['goedgekeurd', 0]])->get();
                    });
                    Cache::rememberForever('nogtekeuren_users', function () {
                        return User::where([['activated', 0],['emailverified', 1]])->get();
                    });
                    


    }
}
