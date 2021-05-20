<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFacilityMaintainsTable extends Migration
{
    public function up()
    {
        Schema::table('facility_maintains', function (Blueprint $table) {
            $table->unsignedBigInteger('username_id');
            $table->foreign('username_id', 'username_fk_3339963')->references('id')->on('users');
            $table->unsignedBigInteger('facility_code_id');
            $table->foreign('facility_code_id', 'facility_code_fk_3339964')->references('id')->on('facility_listings');
        });
    }
}
