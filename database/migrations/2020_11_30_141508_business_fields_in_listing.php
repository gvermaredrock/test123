<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BusinessFieldsInListing extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();


        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
}
