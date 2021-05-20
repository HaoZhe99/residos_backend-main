<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventListingsTable extends Migration
{
    public function up()
    {
        Schema::table('event_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('catogery_id');
            $table->foreign('catogery_id', 'catogery_fk_3270934')->references('id')->on('event_categories');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_3380667')->references('id')->on('users');
            $table->unsignedBigInteger('user_group_id')->nullable();
            $table->foreign('user_group_id', 'user_group_fk_3380867')->references('id')->on('roles');
        });
    }
}
