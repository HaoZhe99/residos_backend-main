<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFacilityBooksTable extends Migration
{
    public function up()
    {
        Schema::table('facility_books', function (Blueprint $table) {
            $table->unsignedBigInteger('username_id');
            $table->foreign('username_id', 'username_fk_3339939')->references('id')->on('users');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3339940')->references('id')->on('project_listings');
            $table->unsignedBigInteger('facility_code_id');
            $table->foreign('facility_code_id', 'facility_code_fk_3339941')->references('id')->on('facility_listings');
        });
    }
}
