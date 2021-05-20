<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToVisitorControlsTable extends Migration
{
    public function up()
    {
        Schema::table('visitor_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('username_id');
            $table->foreign('username_id', 'username_fk_3399099')->references('id')->on('users');
            $table->unsignedBigInteger('add_by_id');
            $table->foreign('add_by_id', 'add_by_fk_3399100')->references('id')->on('users');
        });
    }
}
