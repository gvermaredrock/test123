<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadDistributionRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_distribution_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('locality_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('listing_id');
            $table->jsonb('data')->nullable();
            $table->timestamp('expired_at')->default(now()->addMonths(3));
            $table->timestamps();

            $table->index(['city_id','category_id']);
            $table->index(['locality_id','category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lead_distribution_rules');
    }
}
