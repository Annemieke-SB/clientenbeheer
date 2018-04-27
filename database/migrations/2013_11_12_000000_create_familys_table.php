<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('achternaam');
            $table->string('tussenvoegsel');
            $table->string('adres');
            $table->integer('huisnummer');
            $table->string('huisnummertoevoeging');
            $table->string('postcode');
            $table->string('woonplaats');
            $table->string('telefoon');
            $table->tinyInteger('andere_alternatieven')->default(0);
            $table->tinyInteger('goedgekeurd')->default(0);
            $table->longtext('redenafkeuren')->nullable();   
            $table->tinyInteger('definitiefafkeuren')->nullable();                      
            $table->tinyInteger('aangemeld')->default(0);
            $table->longtext('motivering');
            $table->string('email')->unique();
            $table->integer('user_id');
            $table->tinyInteger('bezoek_sintpiet')->default(0);
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
        Schema::drop('familys');
    }
}
