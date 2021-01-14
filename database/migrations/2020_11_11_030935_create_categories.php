<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategories extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->string('title');
            $table->jsonb('data')->nullable();
            $table->longText('description')->nullable();
//            $table->timestamps();

            $table->index('slug');
        });
    }

    public function down()
    {
//        Schema::dropIfExists('categories');
    }
}
