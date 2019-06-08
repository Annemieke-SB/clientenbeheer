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
<option value="" selected="selected">-</option><option value="2">Schuldhulpverlening</option><option value="3">Geestelijke hulpverlening</option><option value="4">Medische hulpverlening</option><option value="5">BSO / Kinderopvang</option><option value="6">Basisschool</option><option value="7">Voortgezet onderwijs</option><option value="8">Daklozenopvang</option><option value="9">Sociale wijkteam</option><option value="10">Sportvereniging</option><option value="11">Vakbond</option><option value="12">Religieuze instelling</option><option value="30">Overige overheid</option><option value="31">Overige stichtingen</option><option value="32">Overige bedrijven</option><option value="33">Overige verenigingen</option><option value="34">Overige organisaties</option><option value="35">Overige onderwijs</option></select>
