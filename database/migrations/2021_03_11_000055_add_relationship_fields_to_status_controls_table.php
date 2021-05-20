<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStatusControlsTable extends Migration
{
    public function up()
    {
        Schema::table('status_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('project_code_id')->nullable();
            $table->foreign('project_code_id', 'project_code_fk_3389319')->references('id')->on('project_listings');
        });
    }
}
