<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpirationToListings extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->timestamp('expires_at')->default(now()->addYears(10));
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
}
