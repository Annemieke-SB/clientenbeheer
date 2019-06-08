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
        ],[
            'omschrijving' => 'Medische hulpverlening',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'BSO / Kinderopvang',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Basisschool',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Voortgezet onderwijs',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Daklozenopvang',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Sociale wijkteam',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Sportvereniging',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Vakbond',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Religieuze instelling',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige overheid',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige stichtingen',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige bedrijven',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige verenigingen',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige organisaties',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige onderwijs',
            'user_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]
    ]);
    }
}

