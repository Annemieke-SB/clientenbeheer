<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('voornaam', 20);
            $table->string('achternaam', 20);
            $table->string('adres', 50)->nullable();
            $table->string('postcode', 6)->nullable();
            $table->string('woonplaats', 20)->nullable();
            $table->string('telefoon', 10)->nullable();
            $table->string('telefoon2', 10)->nullable();
            $table->string('priveemail', 200)->nullable();
            $table->integer('sintbankemail_id')->unsigned()->nullable();         
            $table->string('functie', 20)->nullable();
            $table->string('regio', 200)->nullable();
            $table->longText('notities')->nullable();
            $table->timestamps();
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->foreign('sintbankemail_id')->references('id')->on('sintbankemails');           
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contacts');
    }
}
