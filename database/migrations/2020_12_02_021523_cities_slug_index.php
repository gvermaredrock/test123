<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CitiesSlugIndex extends Migration
{
    public function up()
    {
        Schema::table('cities', function (Blueprint $table) {
//            $table->index('slug');
        });
    }

    public function down()
    {
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
}
