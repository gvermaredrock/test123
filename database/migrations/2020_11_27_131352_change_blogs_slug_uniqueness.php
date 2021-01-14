<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeBlogsSlugUniqueness extends Migration
{
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropUnique('w21_blogs_slug_unique');
            $table->unique(['city_id','slug']);
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            //
        });
    }
}
