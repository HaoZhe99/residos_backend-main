<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleLogsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('car_plate')->nullable();
            $table->string('time_in')->nullable();
            $table->string('time_out')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
