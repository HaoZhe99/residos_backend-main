<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProjectTypesTable extends Migration
{
    public function up()
    {
        Schema::table('project_types', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_fk_3269959')->references('id')->on('project_categories');
        });
    }
}
