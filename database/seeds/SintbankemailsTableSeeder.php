<?php

use Illuminate\Database\Seeder;

class SintbankemailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sintbankemails')->insert([
            'sintbankemail' => 'webmaster@sinterklaasbank.nl',
            'sintbankemailuser' => 'sinterklaasb15',
            'sintbankemailww' => 'speculaas',


            
        ]);
    }
}
