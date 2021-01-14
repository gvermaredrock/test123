<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePosts extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('user_id');
            $table->string('slug')->unique();
            $table->text('title');
            $table->longText('body')->nullable();
            $table->jsonb('data')->nullable();


            $table->timestamps();
            $table->index('listing_id');
            $table->index('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
