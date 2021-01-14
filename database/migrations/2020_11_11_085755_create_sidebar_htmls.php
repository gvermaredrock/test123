<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSidebarHtmls extends Migration
{
    public function up()
    {
        Schema::create('sidebar_htmls', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->longText('content');

            $table->index('id');
//            $table->timestamps();
        });
    }

    public function down()
    {
//        Schema::dropIfExists('sidebar_htmls');
    }
}
