<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Worktime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worktime', function (Blueprint $table) {
            $table->bigIncrements('id');            
            $table->timestamp('start');
            $table->timestamp('end');
            $table->string('comment');
            $table->unsignedBigInteger('idMandate');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idPrice');
            $table->foreign('idMandate')->references('id')->on('mandate');
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idPrice')->references('id')->on('price');
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
        Schema::dropIfExists('worktime');
    }
}
