<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntermediairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intermediairs', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('type')->default(0);
            $table->string('adres');
            $table->string('huisnummer');
            $table->string('huisnummertoevoeging');
            $table->string('postcode');
            $table->string('woonplaats');            
            $table->integer('user_id');
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
        Schema::drop('intermediairs');
    }
}
