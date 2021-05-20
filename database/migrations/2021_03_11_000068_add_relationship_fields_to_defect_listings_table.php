<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDefectListingsTable extends Migration
{
    public function up()
    {
        Schema::table('defect_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_fk_3270792')->references('id')->on('defect_categories');
            $table->unsignedBigInteger('status_control_id')->nullable();
            $table->foreign('status_control_id', 'status_control_fk_3337470')->references('id')->on('status_controls');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3349266')->references('id')->on('project_listings');
        });
    }
}
