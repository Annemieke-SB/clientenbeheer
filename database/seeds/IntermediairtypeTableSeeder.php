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
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Geestelijke hulpverlening',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Medische hulpverlening',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'BSO / Kinderopvang',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Basisschool',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Voortgezet onderwijs',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Daklozenopvang',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Sociale wijkteam',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Sportvereniging',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Vakbond',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Religieuze instelling',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige overheid',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige stichtingen',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige bedrijven',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige verenigingen',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige organisaties',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],[
            'omschrijving' => 'Overige onderwijs',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]
    ]);
    }
}

