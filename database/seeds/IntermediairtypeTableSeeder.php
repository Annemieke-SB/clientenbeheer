<?php

use Illuminate\Database\Seeder;

class IntermediairtypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('intermediairtypes')->insert([[
            'omschrijving' => 'Schuldhulpverlening',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Geestelijke hulpverlening',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]
    ]);
    }
}

