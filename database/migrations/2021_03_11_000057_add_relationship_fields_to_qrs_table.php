<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToQrsTable extends Migration
{
    public function up()
    {
        Schema::table('qrs', function (Blueprint $table) {
            $table->unsignedBigInteger('username_id')->nullable();
            $table->foreign('username_id', 'username_fk_3340049')->references('id')->on('users');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3340051')->references('id')->on('project_listings');
            $table->unsignedBigInteger('unit_owner_id')->nullable();
            $table->foreign('unit_owner_id', 'unit_owner_fk_2969291')->references('id')->on('unit_mangements');
        });
    }
}
