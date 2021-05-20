<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFamilyControlsTable extends Migration
{
    public function up()
    {
        Schema::table('family_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('family_id');
            $table->foreign('family_id', 'family_fk_2908790')->references('id')->on('users');
            $table->unsignedBigInteger('unit_owner_id');
            $table->foreign('unit_owner_id', 'unit_owner_fk_2969299')->references('id')->on('unit_mangements');
        });
    }
}
