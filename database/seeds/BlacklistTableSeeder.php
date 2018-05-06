<?php

use Illuminate\Database\Seeder;

class BlacklistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blacklist')->insert([[
            'email' => 'henrique@van.huisste.de',
            'reden' => 'Dit is een schelm.',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'email' => 'tester@gekkie.nl',
            'reden' => 'Want hij is te lastig.',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]
    ]);
    }
}
