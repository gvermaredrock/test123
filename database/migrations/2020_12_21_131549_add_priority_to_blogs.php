<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriorityToBlogs extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('priority')->default('false');
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            //
        });
    }
}
