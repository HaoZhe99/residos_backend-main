<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUnitMangementsTable extends Migration
{
    public function up()
    {
        Schema::table('unit_mangements', function (Blueprint $table) {
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3340012')->references('id')->on('project_listings');
            $table->unsignedBigInteger('unit_id');
            $table->foreign('unit_id', 'unit_fk_3340013')->references('id')->on('add_units');
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreign('owner_id', 'owner_fk_3340014')->references('id')->on('users');
        });
    }
}
