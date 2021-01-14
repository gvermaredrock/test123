<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListings extends Migration
{
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->bigIncrements('id');

            // meta title, meta dscr, slug, blog_id
            $table->text('meta_title');
            $table->text('meta_description');
            $table->string('slug')->unique();

            // title, description
            $table->string('title');
            $table->longText('pre_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('post_description')->nullable();

            $table->unsignedBigInteger('city_id');

            // id2
            $table->string('id2')->unique()->nullable();

            // data, raw
            $table->jsonb('data')->nullable();
            $table->jsonb('business_data')->nullable();
            $table->jsonb('raw')->nullable();

            // relations: blog_id, user_id
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->index('slug');
            $table->index(['city_id','slug']);
            $table->index('id');
//            $table->index('id2');
            $table->index('blog_id');

        });
    }

    public function down()
    {
//        Schema::dropIfExists('listings');
    }
}
