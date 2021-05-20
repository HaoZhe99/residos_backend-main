<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGatewaysTable extends Migration
{
    public function up()
    {
        Schema::table('gateways', function (Blueprint $table) {
            $table->unsignedBigInteger('location_code_id')->nullable();
            $table->foreign('location_code_id', 'location_code_fk_3349256')->references('id')->on('locations');
        });
    }
}
