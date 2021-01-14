<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReferences extends Migration
{
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->unsignedBigInteger('blog_id')->nullable();
            $table->text('link');
            $table->text('title');
            $table->string('domain');
            $table->text('snippet');
//            $table->timestamps();
            $table->index('listing_id');
            $table->index('blog_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('references');
    }
}
