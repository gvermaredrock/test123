<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUserInteraction extends Migration
{
    public function up()
    {
        Schema::create('user_interaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('listing_id')->nullable();
            $table->unsignedBigInteger('wuchna_user_id')->default(1);
            $table->longText('body');
            $table->timestamps();
            $table->index('user_id');
            $table->index('listing_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_interaction');
    }
}
