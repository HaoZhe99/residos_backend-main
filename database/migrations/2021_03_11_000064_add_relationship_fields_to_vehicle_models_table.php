<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVehicleModelsTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_models', function (Blueprint $table) {
            $table->unsignedBigInteger('brand_id');
            $table->foreign('brand_id', 'brand_fk_3270409')->references('id')->on('vehicle_brands');
        });
    }
}
