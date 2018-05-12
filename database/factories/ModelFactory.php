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
        'huisnummer' => $faker->buildingNumber,
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
