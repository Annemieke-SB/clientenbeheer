<?php

namespace App\Listeners;

use App\Events\SomeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cache;
use App\User;
use App\Family;
use App\Kid;
use App\Barcode;

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

                    dd('hier');

        // Nieuwe cache aanleggen

                    $intermediairzonderfamilies = Cache::rememberForever('intermediairzonderfamilies', function () {
                        return User::where('usertype',3)->whereDoesntHave('familys')->where('activated', 1)->get();
                    });
                    $familieszonderkinderen = Cache::rememberForever('familieszonderkinderen', function () {
                        return Family::whereDoesntHave('kids')->get();
                    });
                    $nogtekeuren_families = Cache::rememberForever('nogtekeuren_families', function () {
                        return Family::where([['aangemeld', 1],['goedgekeurd', 0]])->get();
                    });
                    $nogtekeuren_users = Cache::rememberForever('nogtekeuren_users', function () {
                        return User::where([['activated', 0],['emailverified', 1]])->get();
                    });
                    $intermediairmetnietgedownloadepdfs = Cache::rememberForever('intermediairmetnietgedownloadepdfs', function () {
                        return User::whereHas('barcodes', function($query){
                            $query->whereNull('downloadedpdf');
                        })->get();
                    });


    }
}
