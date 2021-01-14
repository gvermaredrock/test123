<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogs extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();

            // meta title, meta dscr, slug
            $table->text('meta_title');
            $table->text('meta_description');

            // title, description
            $table->string('title');
            $table->longText('description');

            // region, locality, category
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('locality_id')->nullable();
            $table->unsignedBigInteger('category_id');

            // data, raw
            $table->jsonb('data')->nullable();
            $table->jsonb('raw')->nullable();
            $table->timestamps();
            $table->timestamp('expires_at')->nullable()->default(now()->addDecade());

            $table->index('slug');
            $table->index('city_id');
            $table->index(['locality_id','category_id']);
            $table->index('category_id');

        });
    }

    public function down()
    {
//        Schema::dropIfExists('lps');
    }
}
