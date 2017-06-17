<?php

use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'voornaam' => 'Henrique',
            'achternaam' => 'van Huisstede',
            'adres' => 'Regenboogweg 66',
            'postcode' => '1339GV',
            'woonplaats' => 'Almere',
            'telefoon' => '0643851281',
            'telefoon2' => '0365212052',
            'sintbankemail_id' => 1,
            'priveemail' => 'henrique@van.huisste.de',
            'functie' => 'Webmaster',
        ]);
    }
}
