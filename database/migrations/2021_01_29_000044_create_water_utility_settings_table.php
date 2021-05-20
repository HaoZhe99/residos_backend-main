<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterUtilitySettingsTable extends Migration
{
    public function up()
    {
        Schema::create('water_utility_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount_per_consumption', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
