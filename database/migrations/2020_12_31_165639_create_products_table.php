<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_id');
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->string('slug')->unique();
            $table->text('title');
            $table->text('body')->nullable();
            $table->jsonb('data')->nullable();
            $table->timestamps();

            $table->index('listing_id');
            $table->index('slug');
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
