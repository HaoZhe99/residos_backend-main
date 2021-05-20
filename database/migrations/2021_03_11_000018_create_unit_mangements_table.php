<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitMangementsTable extends Migration
{
    public function up()
    {
        Schema::create('unit_mangements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('floor_size');
            $table->string('bed_room');
            $table->string('toilet');
            $table->string('floor_level')->nullable();
            $table->string('carpark_slot')->nullable();
            $table->boolean('bumi_lot')->default(0)->nullable();
            $table->string('block')->nullable();
            $table->string('status')->nullable();
            $table->boolean('balcony')->default(0)->nullable();
            $table->string('unit_code')->nullable();
            $table->string('unit_owner');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
