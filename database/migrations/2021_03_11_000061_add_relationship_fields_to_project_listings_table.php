<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToProjectListingsTable extends Migration
{
    public function up()
    {
        Schema::table('project_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id')->nullable();
            $table->foreign('type_id', 'type_fk_3270071')->references('id')->on('project_types');
            $table->unsignedBigInteger('developer_id')->nullable();
            $table->foreign('developer_id', 'developer_fk_3270073')->references('id')->on('developer_listings');
            $table->unsignedBigInteger('area_id')->nullable();
            $table->foreign('area_id', 'area_fk_3380067')->references('id')->on('areas');
            $table->unsignedBigInteger('pic_id')->nullable();
            $table->foreign('pic_id', 'pic_fk_3389519')->references('id')->on('pics');
            $table->unsignedBigInteger('create_by')->nullable();
            $table->foreign('create_by', 'user_fk_3272095')->references('id')->on('users');
        });
    }
}
