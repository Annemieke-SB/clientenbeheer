<?php

use Illuminate\Database\Seeder;

class KidsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kids')->insert([[
            'voornaam' => 'Jaap',
            'achternaam' => 'de Vries',
            'geslacht' => 'm',
            'geboortedatum' => '03-03-2003',
            'family_id' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Achmed',
            'achternaam' => '',
            'geslacht' => 'm',
            'geboortedatum' => '11-04-1999',
            'family_id' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Swetlana',
            'achternaam' => 'Bubbelmans',
            'geslacht' => 'v',
            'geboortedatum' => '05-02-2006',
            'family_id' => 1,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Joop',
            'achternaam' => 'Janssen',
            'geslacht' => 'm',
            'geboortedatum' => '13-07-2006',
            'family_id' => 2,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Bordiashanti',
            'achternaam' => '',
            'geslacht' => 'v',
            'geboortedatum' => '11-02-1972',
            'family_id' => 2,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Cornelis',
            'achternaam' => 'Kraam',
            'geslacht' => 'm',
            'geboortedatum' => '13-03-2010',
            'family_id' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Kim',
            'achternaam' => 'de Wilde',
            'geslacht' => 'v',
            'geboortedatum' => '06-02-2010',
            'family_id' => 4,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Bassie',
            'achternaam' => '',
            'geslacht' => 'm',
            'geboortedatum' => '03-03-2011',
            'family_id' => 4,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Blop',
            'achternaam' => '',
            'geslacht' => 'm',
            'geboortedatum' => '03-03-2015',
            'family_id' => 5,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ],
        [
            'voornaam' => 'Adriaan',
            'achternaam' => '',
            'geslacht' => 'm',
            'geboortedatum' => '05-03-2007',
            'family_id' => 5,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]]);
    }
}
