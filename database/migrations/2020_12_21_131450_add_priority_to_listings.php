<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityToListings extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->boolean('priority')->default('false');
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
}
