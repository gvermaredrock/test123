<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeListingsSlugUniqueness extends Migration
{
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropUnique('w21_listings_slug_unique');
            $table->unique(['city_id','slug']);
        });
    }

    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            //
        });
    }
}
