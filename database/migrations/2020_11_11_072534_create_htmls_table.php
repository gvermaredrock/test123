<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHtmlsTable extends Migration
{
    public function up()
    {
        Schema::create('htmls', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->longText('content');

            $table->index('id');
//            $table->timestamps();
        });
    }

    public function down()
    {
//        Schema::dropIfExists('htmls');
    }
}
