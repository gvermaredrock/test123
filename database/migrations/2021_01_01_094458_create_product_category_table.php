<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoryTable extends Migration
{
    public function up()
    {
        Schema::create('product_category', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_id');
            $table->text('title');
            $table->text('body')->nullable();
            $table->jsonb('data')->nullable();
            $table->timestamps();

            $table->index('listing_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_category');
    }
}
