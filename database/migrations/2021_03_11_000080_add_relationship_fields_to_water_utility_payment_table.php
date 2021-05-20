<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWaterUtilityPaymentTable extends Migration
{
    public function up()
    {
        Schema::table('water_utility_payments', function (Blueprint $table) {
            $table->unsignedBigInteger('unit_owner_id');
            $table->foreign('unit_owner_id', 'project_fk_3337475')->references('id')->on('unit_mangements');
        });
    }
}
