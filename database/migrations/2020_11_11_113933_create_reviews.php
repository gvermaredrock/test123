<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviews extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->text('body');
            $table->text('vendor_reply')->nullable();
            $table->smallInteger('rating');
            $table->jsonb('data')->nullable();
            $table->timestamps();
            $table->timestamp('replied_at')->nullable();

            $table->index('listing_id');
            $table->index(['listing_id','user_id']);
//            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
