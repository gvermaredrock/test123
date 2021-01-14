<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalities extends Migration
{
    public function up()
    {
        Schema::create('localities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('city_id');
            $table->string('slug');
            $table->string('title');
            $table->jsonb('data')->nullable();
            $table->jsonb('nearbyplaces')->nullable();

            $table->index('id');
            $table->index('slug');
            $table->unique(['city_id','slug']);
//            $table->timestamps();
        });
    }

    public function down()
    {
//        Schema::dropIfExists('localities');
    }
}
