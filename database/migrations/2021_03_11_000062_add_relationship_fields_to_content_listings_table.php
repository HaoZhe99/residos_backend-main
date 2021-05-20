<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToContentListingsTable extends Migration
{
    public function up()
    {
        Schema::table('content_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id', 'type_fk_3270342')->references('id')->on('content_types');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3380578')->references('id')->on('project_listings');
        });
    }
}
