<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Family;
use App\Kid;
use App\Barcode;


class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_hele_naam()
    {
	$user = new User;

	$user->voornaam = "Henrique";
	$user->achternaam = "Huisstede";
	$user->tussenvoegsel = "van";


        $this->assertEquals($user->naam, "Henrique van Huisstede");
    }

    public function test_barcode_loskoppelen_bij_wissen_user()
    {


	$user = User::create(

        [   
            'organisatienaam' => 'Unittest',
            'voornaam' => 'Unittest',
            'tussenvoegsel' => '',
            'achternaam' => 'Unittest',
            'email' => 'nnn'.rand(1,100000).'@n.Unittest'.rand(1,1000000).'.de',
            'geslacht' => 'v',  
            'functie' => 'Unittest', 
            'password' => 'Unittest',
            'emailverified' => 1,
            'reden' => 'is pain, but because Unittest',
            'website' => 'http://www.Unittest.ck',
            'telefoon' => '0612345678',
            'type' => 4,
            'adres' => 'Unittest',
            'huisnummer' => 25,
            'huisnummertoevoeging' => '',
            'postcode' => '3211AC',
            'woonplaats' => 'Unittest',
            'activated' => 1,
            'usertype' => 3,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]);
	
	$family = Family::create(
	[
            'achternaam' => 'Unittest',
            'tussenvoegsel' => '',
            'adres' => 'de Unittest',
            'huisnummer' => 29,
            'huisnummertoevoeging' => '',
            'postcode' => '9621CC',
            'woonplaats' => 'Unittest',
            'telefoon' => '0641160276',
            'andere_alternatieven' => 1,
	    'motivering' => 'm. Unittest lorem ante, dapibus in, viverra quis, feugiat a,',
            'email' => 'susann.x'.rand(1,100000).'@Unittest'.rand(1,100000).'.com',
            'user_id' => $user->id,
            'bezoek_sintpiet' => 0,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
        ]);

	$kid = Kid::create(
	[
            'voornaam' => 'Unittest',
            'tussenvoegsel' => '',
            'achternaam' => '',
            'geslacht' => 'm',
            'geboortedatum' => '11-04-1999',
            'family_id' => $family->id,       
            'user_id' => $user->id,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]);
	
	$barcode = Barcode::create(
	[//1
            'barcode' => '629993003unit'.rand(10000, 99999),
            'kid_id' => $kid->id,     
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),             
        ]);

	$barcodeCheckedBeforeDelete = Barcode::where('kid_id', $kid->id)->first();
	

	//$response = $this->call('POST', 'FamilyController@setafkeurtext', ['id'=> $family->id]);


    $this->visit('FamilyController@setafkeurtext')
         ->type($family->id, 'id')
         ->type("test unit test", 'redenafkeuren')
         ->uncheck('definitiefafkeuren');


    $barcodeCheckedAfterDelete = Barcode::where('barcode', $barcode->barcode)->first();

    //dd($barcodeCheckedAfterDelete);

        $this->assertEquals($barcode->barcode, $barcodeCheckedBeforeDelete->barcode);
        $this->assertEquals(NULL, $barcodeCheckedAfterDelete->kid_id);
    }


}
