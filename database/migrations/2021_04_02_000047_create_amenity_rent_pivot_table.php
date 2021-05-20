<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmenityRentPivotTable extends Migration
{
    public function up()
    {
        Schema::create('amenity_rent', function (Blueprint $table) {
            $table->unsignedBigInteger('rent_id');
            $table->foreign('rent_id', 'rent_id_fk_3582553')->references('id')->on('rents')->onDelete('cascade');
            $table->unsignedBigInteger('amenity_id');
            $table->foreign('amenity_id', 'amenity_id_fk_3582553')->references('id')->on('amenities')->onDelete('cascade');
        });
    }
}
