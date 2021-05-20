<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location');
            $table->boolean('in_enable')->default(0)->nullable();
            $table->string('location_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
