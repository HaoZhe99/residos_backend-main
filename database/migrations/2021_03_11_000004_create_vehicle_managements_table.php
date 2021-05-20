<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleManagementsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('car_plate');
            $table->boolean('is_verify')->default(0)->nullable();
            $table->boolean('is_season_park')->default(0)->nullable();
            $table->boolean('is_resident')->default(0)->nullable();
            $table->string('color')->nullable();
            $table->string('driver')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
