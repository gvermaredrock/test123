<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedirectsTable extends Migration
{
    public function up()
    {
        Schema::create('redirects', function (Blueprint $table) {
//            $table->bigIncrements('id');
            $table->string('from');
            $table->string('to');
$table->index('from');
//            $table->timestamps();
        });
    }

    public function down()
    {
//        Schema::dropIfExists('redirects');
    }
}
