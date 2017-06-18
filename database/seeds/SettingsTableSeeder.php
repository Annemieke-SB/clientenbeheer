<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([

        [
            'setting' => 'min_leeftijd',
            'value' => 2,
            'lastTamperedUser_id' => 1,
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(), 
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),                 
        ],        
        [
            'setting' => 'max_leeftijd',
            'value' => 9,
            'lastTamperedUser_id' => 1,   
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),          
        ],                
        [
            'setting' => 'max_leeftijd_broer_zus',
            'value' => 11,
            'lastTamperedUser_id' => 1,   
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),          
        ],          
        [
            'setting' => 'inschrijven_gesloten',
            'value' => 0,
            'lastTamperedUser_id' => 1,   
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),          
        ],          
        [
            'setting' => 'adminemails',
            'value' => 'henrique@van.huisste.de',
            'lastTamperedUser_id' => 1,   
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),          
        ], 

        ]);
    }
}
