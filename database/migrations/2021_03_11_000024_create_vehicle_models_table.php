<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleModelsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('model');
            $table->boolean('is_enable')->default(0)->nullable();
            $table->string('type')->nullable();
            $table->string('color')->nullable();
            $table->string('variant')->nullable();
            $table->string('series')->nullable();
            $table->string('release_year')->nullable();
            $table->integer('seat_capacity')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('wheel_base')->nullable();
            $table->string('kerb_weight')->nullable();
            $table->string('fuel_tank')->nullable();
            $table->string('front_brake')->nullable();
            $table->string('rear_brake')->nullable();
            $table->string('front_suspension')->nullable();
            $table->string('rear_suspension')->nullable();
            $table->string('steering')->nullable();
            $table->string('engine_cc')->nullable();
            $table->string('compression_ratio')->nullable();
            $table->string('peak_power_bhp')->nullable();
            $table->string('peak_torque_nm')->nullable();
            $table->string('engine_type')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('driven_wheel_drive')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
