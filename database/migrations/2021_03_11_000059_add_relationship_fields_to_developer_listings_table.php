<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDeveloperListingsTable extends Migration
{
    public function up()
    {
        Schema::table('developer_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('pic_id');
            $table->foreign('pic_id', 'pic_fk_3389432')->references('id')->on('pics');
        });
    }
}
