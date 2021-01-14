<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCase extends Migration
{
    public function up()
    {
        Schema::create('report_case', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('listing_id');
            $table->text('body');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->jsonb('data')->nullable();
            $table->timestamps();

            $table->index('listing_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
//        Schema::dropIfExists('report_case');
    }
}
