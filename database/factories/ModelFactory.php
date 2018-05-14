<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

	return [
        'organisatienaam' => $faker->company,
        'voornaam' => $faker->firstName($gender = 'male'|'female'),
        'achternaam' => $faker->lastName,
        'tussenvoegsel' => $faker->randomElement($array = array ('','van','van der', 'de')),
        'geslacht' => $faker->randomElement($array = array('m','v')),
        'functie' => $faker->jobTitle,
        'emailverified' => 1,
        'reden' => $faker->text($maxNbChars=150),
        'website' => $faker->url,
        'telefoon' => $faker->e164PhoneNumber,
        'type' => $faker->randomElement($array = array(1,2,3,4,5,6,7,8,9,10,11,12)),
        'adres' => $faker->streetName,
        'huisnummer' => $faker->numberBetween($min = 10, $max = 500),
        'huisnummertoevoeging' => 'a',
        'postcode' => $faker->postcode,
        'woonplaats' => $faker->city,
        'activated' => 1,
        'usertype' => 3,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
];





});


$factory->define(App\Family::class, function (Faker\Generator $faker) {
    //static $password;

	return [
            'achternaam' => $faker->lastName,
            'tussenvoegsel' => $faker->randomElement($array = array ('','van','van der', 'de')),
            'adres' => $faker->streetName,
            'huisnummer' => $faker->numberBetween($min = 10, $max = 500),
            'huisnummertoevoeging' => 'b',
            'postcode' => $faker->postcode,
            'woonplaats' => $faker->city,
            'telefoon' => $faker->e164PhoneNumber,
            'andere_alternatieven' => 0,
            'motivering' => $faker->text($maxNbChars=150),
            'user_id' => $faker->numberBetween($min = 10, $max = 500),
            'bezoek_sintpiet' => 0,    
            'email' => $faker->unique()->safeEmail,  
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),      
];
});

$factory->define(App\Kid::class, function (Faker\Generator $faker) {
    //static $password;

	$family = App\Family::find($faker->numberBetween($min = 10, $max = 500));

		$d = $faker->numberBetween($min = 1, $max = 28);
		$m = $faker->numberBetween($min = 1, $max = 12);
		$y = $faker->numberBetween($min = 2005, $max = date("Y")-1);
		$datum = "$d-$m-$y";

	return [
            'voornaam' => $faker->firstName($gender = 'male'|'female'),
            'tussenvoegsel' => $faker->randomElement($array = array ('','van','van der', 'de')),
            'achternaam' => $faker->lastName,
            'geslacht' => $faker->randomElement($array = array('m','v')),
            'geboortedatum' => date("d-m-Y", strtotime($datum)), 
            'family_id' => $family->id,       
            'user_id' => $family->user->id,       
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),       
];
});
