<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToAddUnitsTable extends Migration
{
    public function up()
    {
        Schema::table('add_units', function (Blueprint $table) {
            $table->unsignedBigInteger('block_id');
            $table->foreign('block_id', 'block_fk_2905320')->references('id')->on('add_blocks');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3340013')->references('id')->on('project_listings');
        });
    }
}
