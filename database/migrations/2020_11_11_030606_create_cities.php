<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCities extends Migration
{
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
//            $table->timestamps();

            $table->index('slug');
            $table->index('id');
        });
    }

    public function down()
    {
//        Schema::dropIfExists('cities');
    }
}
