<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVehicleLogsTable extends Migration
{
    public function up()
    {
        Schema::table('vehicle_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id', 'location_fk_3270466')->references('id')->on('locations');
        });
    }
}
