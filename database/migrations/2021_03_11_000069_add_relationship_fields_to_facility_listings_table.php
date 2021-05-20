<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFacilityListingsTable extends Migration
{
    public function up()
    {
        Schema::table('facility_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_fk_3339909')->references('id')->on('facility_categories');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3339910')->references('id')->on('project_listings');
        });
    }
}
