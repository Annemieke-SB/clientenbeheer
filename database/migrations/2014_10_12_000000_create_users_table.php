<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('organisatienaam');
            $table->string('voornaam');
            $table->string('tussenvoegsel');
            $table->string('achternaam');
            $table->string('geslacht')->default('-');
            $table->string('email')->unique();
            $table->string('functie')->nullable();
            $table->string('password');
            $table->integer('emailverified')->default(0);
            $table->string('email_token')->nullable();
            $table->longtext('reden');            
            $table->string('website');
            $table->string('telefoon');
            $table->integer('type')->default(0);
            $table->string('adres');
            $table->string('huisnummer');
            $table->string('huisnummertoevoeging');
            $table->string('postcode');
            $table->string('woonplaats');                       
            $table->integer('activated')->default(0);
            $table->tinyInteger('nieuwsbrief')->default(0);
            $table->integer('usertype')->default(3); // 1 = admin, 2 = raadpleger, 3 = intermediair
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
