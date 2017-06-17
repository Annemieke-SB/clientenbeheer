<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSintbankemailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sintbankemails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sintbankemail', 200);
            $table->string('sintbankemailuser', 200)->nullable();
            $table->string('sintbankemailww', 200)->nullable();
            $table->longText('notities')->nullable();
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
        Schema::drop('sintbankemails');
    }
}
