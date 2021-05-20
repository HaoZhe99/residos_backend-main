<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventEnrollsTable extends Migration
{
    public function up()
    {
        Schema::table('event_enrolls', function (Blueprint $table) {
            $table->unsignedBigInteger('username_id')->nullable();
            $table->foreign('username_id', 'username_fk_3339894')->references('id')->on('users');
            $table->unsignedBigInteger('event_code_id');
            $table->foreign('event_code_id', 'event_code_fk_3339895')->references('id')->on('event_listings');
        });
    }
}
