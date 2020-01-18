<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use App\Family;
use App\Kid;
use App\Barcode;
use App\Setting;
use DB;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model;



/**
- TODO
--- https://clientenbeheer.test/search?q=floris70 (kan bekeken worden zonder inlog)
**/



class TotalTest extends TestCase
{
		//use RefreshDatabase;

	//use WithoutMiddleware;

/**
* Hier de tests voor de usergedeelte
*
*/

    /* =======
	 * Tests voor de userindex
	 */


	    public function testUsersindex_not_logged_in()
	    {
	    	// Gasten mogen de pagina niet zien

	        $response = $this->get('/users')->assertRedirect('/login');

	        //Feedback
	        echo "\n\nGEBRUIKERSINDEX BEKIJKEN\n========================"; 
			echo "\n* Een niet ingelogde gebruiker kan gebruikersindex NIET bekijken.";  
	    }

	    public function testUsersindex_als_intermediair()
	    {

	    	// Intermediairs moeten naar hun eigen pagina worden geleid

			$intermediair = factory(User::class)->create(['usertype'=>'3']);
			$this->actingAs($intermediair);

	        $response = $this->get('/users')->assertRedirect('/home');

	        //Opschoon
	        DB::table('users')->where('id', '=', $intermediair->id)->delete();	 

	        //Feedback
			echo "\n* Een intermediair kan gebruikersindex NIET bekijken.";  
	    }

	    public function testUsersindex_als_admin()
	    {

	    	// Alleen admins mogen de pagina zien

	    	$admin = factory(User::class)->create(['usertype'=>'1']);
	        $this->actingAs($admin);

	        $response = $this->get('/users')->assertStatus(200);

	        //Opschoon
	        DB::table('users')->where('id', '=', $admin->id)->delete();	 

	        //Feedback
			echo "\n* Een admin kan gebruikersindex WEL bekijken.";  

	    }


    /* =======
	 * Tests voor de userdelete
	 */


	    public function testUsersdelete_not_logged_in()
	    {
	    	// Gasten mogen geen users deleten
	    	$user = factory(User::class)->make();
	    	$user->save();
	        $response = $this->get('/user/destroy/'.$user->id)->assertRedirect('/login');

	        //Opschoon
	        DB::table('users')->where('id', '=', $user->id)->delete();	  

	        //Feedback
	        echo "\n\nGEBRUIKERS VERWIJDEREN\n======================"; 
			echo "\n* Een niet ingelogde gebruiker kan gebruikers NIET verwijderen.";        
	    }

	    public function testUsersdelete_als_intermediair()
	    {

	    	// Intermediairs moeten naar hun eigen pagina worden geleid
	    	$user = factory(User::class)->make();
	    	$user->save();

	    	// De testpersoon
			$intermediair = factory(User::class)->create(['usertype'=>'3']);
			$this->actingAs($intermediair);

	        $response = $this->get('/user/destroy/'.$user->id)->assertRedirect('/home');
	        // Nog wel een user uiteraard
			$this->assertDatabaseHas('users', ['id' => $user->id]);


	        //Opschoon
	        DB::table('users')->where('id', '=', $intermediair->id)->delete();
	        DB::table('users')->where('id', '=', $user->id)->delete();

	        //Feedback
			echo "\n* Een intermediair kan gebruikers NIET verwijderen."; 	        
	    }

	    public function testUsersdelete_als_admin_downloads_open()
	    {
	    	// Backup huidige setting
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');


	    	// Admins mogen niet verwijderen als de downloads open staan. 
	    	$user = factory(User::class)->make();
	    	$user->save();


	    	// Downloads inschakelen
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> 1]);


	    	// De testpersoon
			$admin = factory(User::class)->create(['usertype'=>'1']);
			$this->actingAs($admin);
	    	
	        $response = $this->get('/user/destroy/'.$user->id)->assertSessionHas('message', 'Het is niet mogelijk om gebruikers te verwijderen nadat de inschrijvingen zijn gesloten. Dit omdat er mogelijk kinderen aan gekoppeld zitten die al een PDF tot hun beschikking hebben. Je zou wel de gebruiker (intermediair) kunnen deactiveren in het gebruikersoverzicht.');
			// Ook geen user uiteraard
			$this->assertDatabaseHas('users', ['id' => $user->id]);

	        //Opschoon
	        DB::table('users')->where('id', '=', $admin->id)->delete();


	        //Feedback
			echo "\n* Een admin kan gebruikers NIET verwijderen als de downloads open staan (ivm mogelijk gedownloadde codes)."; 	     

	    	// Instelling terugzetten
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);			   
	    }


	    public function testUsersdelete_als_admin_downloads_gesloten()
	    {

	    	// Backup huidige setting
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');


	    	// Downloads uitschakelen
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> 0]);

	    	// Alleen admins mogen de pagina zien
	    	$user = factory(User::class)->make();
	    	$user->save();

	    	// De testpersoon
			$admin = factory(User::class)->create(['usertype'=>'1']);
			$this->actingAs($admin);
	    	
	        $response = $this->get('/user/destroy/'.$user->id)->assertRedirect('/users/index');
			// Ook geen user uiteraard
			$this->assertDatabaseMissing('users', ['id' => $user->id]);

	        //Opschoon
	        DB::table('users')->where('id', '=', $admin->id)->delete();


	        //Feedback
			echo "\n* Een admin kan gebruikers WEL verwijderen als de downloads gesloten zijn."; 	   

			// Instelling terugzetten
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);	     
	    }


	    public function testUsersdelete_incl_gezinnen_kinderen_en_barcodes_loskopelen()
	    {

	    	// Backup huidige setting
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');	    	

	    	// Downloads uitschakelen
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> 0]);

	    	// Eerst een opschoonactie ivm mogelijk eerder foutgelopen tests.
	    	$bc1 = "PHPUNITTEST1";
	    	$bc2 = "PHPUNITTEST2";
	    	$bc3 = "PHPUNITTEST3";
	    	DB::table('barcodes')->where('barcode', '=', $bc1)->delete();
	    	DB::table('barcodes')->where('barcode', '=', $bc2)->delete();
	    	DB::table('barcodes')->where('barcode', '=', $bc3)->delete();


	    	// Hier wordt een gebruiker aangemaakt, een gezin, een kind en een barcode. De kind en de barcode worden aan elkaar gekoppeld. 
	    	$user = factory(User::class)->make();
	    	$user->save();

			$family = factory(Family::class)->make( ['user_id' => $user->id ] );
			$family->save();

			$family2 = factory(Family::class)->make( ['user_id' => $user->id ] );
			$family2->save();			

			$kid = Kid::create( ['family_id' => $family->id,
								'user_id' =>  $family->user->id,
								'voornaam' => 'Jaap',
								'tussenvoegsel' => 'van',
								'achternaam' => 'Jansen',
								'geboortedatum'=>"20-3-2003",
								'geslacht'=>"m"] );
			$kid->save();

			$kid2 = Kid::create( ['family_id' => $family2->id,
								'user_id' =>  $family->user->id,
								'voornaam' => 'Jan',
								'tussenvoegsel' => 'van',
								'achternaam' => 'Beest',
								'geboortedatum'=>"2-3-2003",
								'geslacht'=>"m"] );
			$kid2->save();

			$kid3 = Kid::create( ['family_id' => $family->id,
								'user_id' =>  $family->user->id,
								'voornaam' => 'John',
								'tussenvoegsel' => 'de',
								'achternaam' => 'Beuker',
								'geboortedatum'=>"1-3-2003",
								'geslacht'=>"m"] );
			$kid3->save();						

			$barcode1 = Barcode::create( ['kid_id' => $kid->id,
								'user_id' =>  $user->id,
								'barcode' => $bc1,
								'downloadedpdf' => NULL] );
			$barcode1->save();

			$barcode2 = Barcode::create( ['kid_id' => $kid2->id,
								'user_id' =>  $user->id,
								'barcode' => $bc2,
								'downloadedpdf' => NULL] );
			$barcode2->save();

			$barcode3 = Barcode::create( ['kid_id' => $kid3->id,
								'user_id' =>  $user->id,
								'barcode' => $bc3,
								'downloadedpdf' => NULL] );
			$barcode3->save();						

			// Hier wordt de gebruiker verwijderd als admin	    	
	        $admin = factory(User::class)->create(['usertype'=>'1']);
	        $this->actingAs($admin);
	        $response = $this->get('/user/destroy/'.$user->id);
	        $response->assertRedirect('/users/index');


	        // Nu moet er geen kind meer in de database staan met dat (user/family)ID
			$this->assertDatabaseMissing('kids', ['id' => $kid->id]);
			$this->assertDatabaseMissing('kids', ['id' => $kid2->id]);
			$this->assertDatabaseMissing('kids', ['id' => $kid3->id]);			
			$this->assertDatabaseMissing('kids', ['user_id' => $user->id]);
			$this->assertDatabaseMissing('kids', ['family_id' => $family->id]);

			// Ook geen user uiteraard
			$this->assertDatabaseMissing('users', ['id' => $user->id]);

			// En geen family, omdat die aan de user hing (net als de kinderen)
			$this->assertDatabaseMissing('familys', ['id' => $family->id]);
			$this->assertDatabaseMissing('familys', ['id' => $family2->id]);
			$this->assertDatabaseMissing('familys', ['user_id' => $user->id]);

			$this->assertDatabaseMissing('barcodes', ['kid_id' => $kid->id]);
			$this->assertDatabaseMissing('barcodes', ['kid_id' => $kid2->id]);
			$this->assertDatabaseMissing('barcodes', ['kid_id' => $kid3->id]);						
			$this->assertDatabaseMissing('barcodes', ['user_id' => $user->id]);

			//opschoonactie voor de barcode
			DB::table('barcodes')->where('id', '=', $barcode1->id)->delete();
			DB::table('barcodes')->where('id', '=', $barcode2->id)->delete();
			DB::table('barcodes')->where('id', '=', $barcode3->id)->delete();						
			DB::table('users')->where('id', '=', $admin->id)->delete();


	        //Feedback
			echo "\n* Bij een verwijderde gebruiker zijn ook de onderliggende gezinnen en kinderen weg, de barcodes zijn losgekoppeld maar niet verwijderd (getest met 1 user, 2 gezinnen en 3 kinderen)";		

			// Instelling terugzetten
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);					

	    }


/**
 * Hier de tests voor de settingsgedeelte
 *
 */

    /* =======
	 * Test voor de settingsindex
	 */

			//Feedback
			  

	    public function testSettingsindex_not_logged_in()
	    {
	    	// Gasten mogen de pagina niet zien

	        $response = $this->get('/settings')->assertRedirect('/login');

	        //Feedback
	        echo "\n\nSETTINGSINDEX\n============="; 
			echo "\n* Een niet ingelogde gebruiker kan de settingsindex NIET bekijken.";   
	    }

	    public function testSettingsindex_als_intermediair()
	    {


	    	// Intermediairs moeten naar hun eigen pagina worden geleid
	    	$intermediair = factory(User::class)->create(['usertype'=>'3']);
	        $this->actingAs($intermediair);

	        $response = $this->get('/settings')->assertRedirect('/home/');

			//opschoonactie
			DB::table('users')->where('id', '=', $intermediair->id)->delete();	

			//Feedback
			echo "\n* Een intermediair kan de settingsindex NIET bekijken.";   	        
	    }

	    public function testSettingsindex_als_admin()
	    {

	    	// Alleen admins mogen de pagina zien

	    	$admin = factory(User::class)->create(['usertype'=>'1']);
	        $this->actingAs($admin);

	        $response = $this->get('/settings')->assertStatus(200);


			//opschoonactie
			DB::table('users')->where('id', '=', $admin->id)->delete();	

			//Feedback
			echo "\n* Een admin kan de settingsindex WEL bekijken.";        
	    }

/**
 * Hier de tests voor de losse settings
 *
 */

    /* =======
	 * Test voor het doorvoeren van settings
	 */


	    public function testInstellingen_werken_voor_admins()
	    {
	    	// Backup huidige waarde

			echo "\n\nLOSSE SETTINGS\n============="; 

	    	$min_leeftijd = Setting::get('min_leeftijd');	
	    	$max_leeftijd = Setting::get('max_leeftijd');	
	    	$max_leeftijd_broer_zus = Setting::get('max_leeftijd_broer_zus');
	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');
	    	$adminemails = Setting::where('id', '=', 5)->first();
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');


	    	// Gasten mogen de instellingen NIET aanpassen

	        // Instelling 1 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 1)->update(['value'=> 1]);
	        $response = $this->post('/settings/update/1', ['value'=>5, 'id'=>1]);
	        $response->assertRedirect('/login/');
			$this->assertDatabaseHas('settings', ['id' => 1, 'value' => 1]);
			DB::table('settings')->where('id', '=', 1)->update(['value'=> $min_leeftijd]);

			//Feedback
			echo "\n* Een niet ingelogde gebruiker kan GEEN settings verwerken."; 


	    	// Intermediairs mogen de instellingen NIET aanpassen
	    	$intermediair = factory(User::class)->create(['usertype'=>'3']);
	        $this->actingAs($intermediair);

	        // Instelling 1 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 1)->update(['value'=> 1]);
	        $response = $this->post('/settings/update/1', ['value'=>5, 'id'=>1]);
	        $response->assertRedirect('/user/show/' . $intermediair->id);
			$this->assertDatabaseHas('settings', ['id' => 1, 'value' => 1]);
			DB::table('settings')->where('id', '=', 1)->update(['value'=> $min_leeftijd]);

			//Feedback
			echo "\n* Een intermediair kan GEEN settings verwerken."; 


	    	// Alleen admins mogen de instellingen aanpassen zien
	    	$admin = factory(User::class)->create(['usertype'=>'1']);
	        $this->actingAs($admin);

	        // Instelling 1 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 1)->update(['value'=> 1]);
	        $response = $this->post('/settings/update/1', ['value'=>5, 'id'=>1]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling gewijzigd");
			$this->assertDatabaseHas('settings', ['id' => 1, 'value' => 5]);
			DB::table('settings')->where('id', '=', 1)->update(['value'=> $min_leeftijd]);

	        // Instelling 2 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 2)->update(['value'=> 9]);
	        $response = $this->post('/settings/update/2', ['value'=>10, 'id'=>2]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling gewijzigd");
			$this->assertDatabaseHas('settings', ['id' => 2, 'value' => 10]);
			DB::table('settings')->where('id', '=', 2)->update(['value'=> $max_leeftijd]);

	        // Instelling 3 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 3)->update(['value'=> 11]);
	        $response = $this->post('/settings/update/3', ['value'=>12, 'id'=>3]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling gewijzigd");
			$this->assertDatabaseHas('settings', ['id' => 3, 'value' => 12]);
			DB::table('settings')->where('id', '=', 3)->update(['value'=> $max_leeftijd_broer_zus]);

	        // Instelling 4 (eerst verzetten, dan updaten en eval)
	        DB::table('settings')->where('id', '=', 6)->update(['value'=> 0]);	
			DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);
	        $response = $this->post('/settings/update/4', ['value'=>0, 'id'=>4]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling gewijzigd");
			$this->assertDatabaseHas('settings', ['id' => 4, 'value' => 0]);
			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);	

	        // Instelling 5 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 5)->update(['setting'=> 'gg@fd.nl']);
	        $response = $this->post('/settings/update/5', ['setting'=>'jaap@test.nl,vlap@test.nl', 'id'=>5]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling gewijzigd");
			$this->assertDatabaseHas('settings', ['id' => 5, 'setting' => 'jaap@test.nl,vlap@test.nl']);
			DB::table('settings')->where('id', '=', 5)->update(['setting'=> $adminemails->setting]);

	        // Instelling 6 (eerst verzetten, dan updaten en eval)
			DB::table('settings')->where('id', '=', 6)->update(['value'=> 1]);
	        $response = $this->post('/settings/update/6', ['value'=>5, 'id'=>6]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling gewijzigd");
			$this->assertDatabaseHas('settings', ['id' => 6, 'value' => 5]);
			DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);


	        //Feedback	        
			echo "\n* Een admin kan succesvol alle settings verwerken.";  
				 
	    }

	    public function testGasten_niet_inschrijven_na_inschrijven_gesloten()
	    {

	    	// Backup
	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');
	    	DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);

	    	// Gasten mogen de pagina niet zien

	        $response = $this->get('/inschrijven')->assertViewIs('inschrijvinggesloten');
	        $response = $this->get('/register')->assertSeeText('De inschrijvingen zijn gesloten');

	        //Feedback
			echo "\n* Inschrijving gesloten: Een niet ingelogde gebruiker kan niet meer inschrijven als inschrijving gesloten is."; 
			echo "\n* Inschrijving gesloten: De rechtstreekse inschrijfpagina is niet meer toegankelijk.";  


			// Backup terugzetten
			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);

	    }



	    public function testIntermediairs_kunnen_geen_gezinnen_aanmaken_na_inschrijven_gesloten()
	    {

	    	// Backup
	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');

	    	DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> 0]);

			// Intermediairs 
			$intermediair = factory(User::class)->create(['usertype'=>'3']);
			$this->actingAs($intermediair);

	        $response = $this->get('/familie/toevoegen/' . $intermediair->id)->assertRedirect('home');	        

	        //Feedback
			echo "\n* Inschrijving gesloten: Een intermediair kan GEEN gezin meer aanmaken."; 

			// Backup terugzetten
			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);

	    }


	    public function testIntermediairs_kunnen_geen_gezinnen_aanmelden_na_inschrijven_gesloten()
	    {

	    	// Backup
	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');

	    	DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);
	    	DB::table('settings')->where('id', '=', 6)->update(['value'=> 0]);

			// Intermediairs 
			$intermediair = factory(User::class)->create(['usertype'=>'3']);
			$this->actingAs($intermediair);

			$family = factory(Family::class)->make( ['user_id' => $intermediair->id ] );
			$family->save();

	    	DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);

	        $response = $this->get('/family/aanmelden/' . $family->id);

	        $response->assertSessionHas('message', "U heeft een gezin proberen aan te melden terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.");
   

	        //Feedback
			echo "\n* Inschrijving gesloten: Een intermediair kan GEEN gezin aanmelden."; 

			// Backup terugzetten
			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);			

	    }


	    public function testIntermediairs_kunnen_geen_gezinnen_kinderen_wijzigen_na_inschrijven_gesloten()
	    {

	    	// Backup
	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');

			// Intermediairs 
			$intermediair = factory(User::class)->create(['usertype'=>'3']);
			$this->actingAs($intermediair);

			$family = factory(Family::class)->make( ['user_id' => $intermediair->id ] );
			$family->save();

			$kid = Kid::create( ['family_id' => $family->id,
								'user_id' =>  $family->user->id,
								'voornaam' => 'Jaap',
								'tussenvoegsel' => 'van',
								'achternaam' => 'Jansen',
								'geboortedatum'=>"20-3-2003",
								'geslacht'=>"m"] );
			$kid->save();			

	    	DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);

	        $response = $this->get('/family/edit/' . $family->id);

	        $response->assertSessionHas('message', "U heeft een gezin proberen te wijzigen terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.");
   
	        $response = $this->get('/kids/edit/' . $kid->id);

	        $response->assertSessionHas('message', "U heeft een kind proberen te wijzigen terwijl de inschrijvingen zijn gesloten. U bent weer teruggeleid naar uw startpagina.");

	        //Feedback
			echo "\n* Inschrijving gesloten: Een intermediair kan GEEN gezin of kind meer wijzigen."; 

			// Backup terugzetten
			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);	    	
			DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);

	    }


	    public function testIntermediairs_kunnen_geen_gezinnen_kinderen_verwijderen_na_inschrijven_gesloten()
	    {

	    	// Backup
	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');

			// Intermediairs 
			$intermediair = factory(User::class)->create(['usertype'=>'3']);
			$this->actingAs($intermediair);

			$family = factory(Family::class)->make( ['user_id' => $intermediair->id ] );
			$family->save();

	    	DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);

	        $response = $this->get('/family/destroy/' . $family->id);

	        $response->assertSessionHas('message', "Het is niet mogelijk om gezinnen te verwijderen nadat de inschrijvingen zijn gesloten.");

			$kid = Kid::create( ['family_id' => $family->id,
								'user_id' =>  $family->user->id,
								'voornaam' => 'Jaap',
								'tussenvoegsel' => 'van',
								'achternaam' => 'Jansen',
								'geboortedatum'=>"20-3-2003",
								'geslacht'=>"m"] );
			$kid->save();			

	        $response = $this->get('/kids/destroy/' . $kid->id);

	        $response->assertSessionHas('message', "U heeft een kind proberen te verwijderen terwijl de inschrijvingen zijn gesloten.");

	        //Feedback
			echo "\n* Inschrijving gesloten: Een intermediair kan GEEN gezin of kind meer verwijderen."; 

			// Backup terugzetten
			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);

	    }



	    public function testInschrijving_openen_niet_als_downloads_al_open_staan()
	    {
	    	// Backup huidige waarde

	    	$inschrijven_gesloten = Setting::get('inschrijven_gesloten');
	    	$downloads_ingeschakeld = Setting::get('downloads_ingeschakeld');

	    	// Alleen admins mogen de instellingen aanpassen zien
	    	$admin = factory(User::class)->create(['usertype'=>'1']);
	        $this->actingAs($admin);

	        // Instelling 4 (eerst verzetten, dan updaten en eval)
	        DB::table('settings')->where('id', '=', 6)->update(['value'=> 1]);	// downloads aan
			DB::table('settings')->where('id', '=', 4)->update(['value'=> 1]);  // inschrijving gesloten

	        $response = $this->post('/settings/update/4', ['value'=>0, 'id'=>4]);
	        $response->assertRedirect('/settings/');
	        $response->assertSessionHas('message', "Instelling niet gewijzigd; downloadpagina is al aktief dus er zijn mogelijk al PDFs gedownload.");
			$this->assertDatabaseHas('settings', ['id' => 4, 'value' => 1]);


			DB::table('settings')->where('id', '=', 4)->update(['value'=> $inschrijven_gesloten]);	
			DB::table('settings')->where('id', '=', 6)->update(['value'=> $downloads_ingeschakeld]);


	        //Feedback	        
			echo "\n* Inschrijving weer openen: kan niet als de downloads openstaan.";  
				 
	    }


	    /* =====
	     * TODO
  
			echo "\n* [TODO] Downloads geopend: kan alleen als de inschrijvingen zijn gesloten."; 	
			echo "\n* [TODO] Downloads geopend: Intermediairs kunnen WEL bij eigen PDF's."; 
			echo "\n* [TODO] Downloads geopend: Intermediairs kunnen NIET bij andere PDF's (ook niet bij de overige PDFs van de admins)."; 	
			echo "\n* [TODO] Downloads geopend: Admins kunnen NIET bij andere PDF's."; 
			echo "\n* [TODO] Downloads geopend: Admins kunnen WEL bij overige PDF's (inclusief genereren)."; 
			echo "\n* [TODO] Downloads geopend: Niet ingelogde gebruikers kunnen NIET bij PDF's."; 	  
			echo "\n* [TODO] Goedgekeurde gezinnen: Een intermediair kan GEEN goedgekeurd gezin wijzigen."; 
			echo "\n* [TODO] Goedgekeurde gezinnen: Een intermediair kan GEEN goedgekeurd kind wijzigen."; 
			echo "\n* [TODO] Goedgekeurde gezinnen: Een intermediair kan WEL een goedgekeurd gezin verwijderen."; 
			echo "\n* [TODO] Goedgekeurde gezinnen: Een intermediair kan GEEN goedgekeurd kind verwijderen. Dit kan namelijk de samenstelling van het gezin veranderen waardoor het gezin opnieuw moet worden beoordeeld"; 

			echo "\n\nEMAIL"; 
			echo "\n=====";
			echo "\n* [TODO] De adminmailer werkt";
			echo "\n* [TODO] De gebruiker krijgt een email bij inschrijving";
			echo "\n* [TODO] De gebruiker krijgt een email bij een mailwijziging";
		    echo "\n* [TODO] De gebruiker krijgt een email bij een wijziging";
		    echo "\n* [TODO] De gebruiker krijgt een email bij een wachtwoordreset";

		    echo "\n\nBlacklist";
		    echo "\n=====";
			echo "\n* [TODO] Kan alleen door een admin worden toegevoegd/gewist/gewijzigd";
			echo "\n* [TODO] Als in blacklist, is er een vlaggetje zichtbaar in alle relevante views?";

		==== */ 


}
