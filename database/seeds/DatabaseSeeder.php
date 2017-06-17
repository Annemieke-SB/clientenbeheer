<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    	$this->call(SintbankemailsTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(IntermediairsTableSeeder::class);
        $this->call(FamilysTableSeeder::class);
        $this->call(KidsTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(BarcodesTableSeeder::class);


    }
}
