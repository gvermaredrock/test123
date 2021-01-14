<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHitcounterToBlogs extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->unsignedBigInteger('hitcounter')->default(0);
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            //
        });
    }
}
