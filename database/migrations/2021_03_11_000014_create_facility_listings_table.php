<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityListingsTable extends Migration
{
    public function up()
    {
        Schema::create('facility_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->longText('desctiption');
            $table->string('status');
            $table->time('open');
            $table->time('closed');
            $table->string('facility_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
