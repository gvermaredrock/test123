<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHitcounterToListings extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->unsignedBigInteger('hitcounter')->default(0);
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
}
