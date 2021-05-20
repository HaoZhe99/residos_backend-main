<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWaterUtilitySettingTable extends Migration
{
    public function up()
    {
        Schema::table('water_utility_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id', 'project_fk_3337474')->references('id')->on('project_listings');
        });
    }
}
