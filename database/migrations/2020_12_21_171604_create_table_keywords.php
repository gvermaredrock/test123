<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKeywords extends Migration
{
    public function up()
    {
        Schema::create('keywords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->unsignedBigInteger('blog_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->index('listing_id');
            $table->index('blog_id');
            $table->index('post_id');
            $table->unique(['title','listing_id']);
            $table->unique(['title','blog_id']);
            $table->unique(['title','post_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('keywords');
    }
}
