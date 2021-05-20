<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVehicleManagementsTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_managements', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_3340015')->references('id')->on('users');
            $table->unsignedBigInteger('carpark_location_id')->nullable();
            $table->foreign('carpark_location_id', 'carpark_location_fk_3340016')->references('id')->on('carparklocations');
            $table->unsignedBigInteger('model_id')->nullable();
            $table->foreign('model_id', 'model_fk_3340017')->references('id')->on('vehicle_models');
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id', 'model_fk_3340088')->references('id')->on('vehicle_brands');
        });
    }
}
