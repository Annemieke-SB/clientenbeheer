<?php

use Illuminate\Database\Seeder;

class IntermediairsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('intermediairs')->insert([

            [
            'type' => 4,
            'adres' => 'Boomgaardweg',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Zuidland',
            'user_id' => 2,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
        ],
        [
            'type' => 3,
            'adres' => 'Grintweg',
            'huisnummer' => 70,
            'huisnummertoevoeging' => 'a',
            'postcode' => '9675HL',
            'woonplaats' => 'Winschoten',
            'user_id' => 3,  
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
        ],
        [
            'type' => 2,
            'adres' => 'Goudsmidstraat',
            'huisnummer' => 9,
            'huisnummertoevoeging' => '',
            'postcode' => '5801RE',
            'woonplaats' => 'Venray',
            'user_id' => 4, 
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),           
        ],
        [
            'type' => 1,
            'adres' => 'Goudsmidstraat',
            'huisnummer' => 9,
            'huisnummertoevoeging' => '',
            'postcode' => '5801RE',
            'woonplaats' => 'Almere',
            'user_id' => 8,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),           
        ]





        ]);
    }
}
