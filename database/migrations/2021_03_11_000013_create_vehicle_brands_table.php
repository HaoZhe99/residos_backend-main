<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleBrandsTable extends Migration
{
    public function up()
    {
        Schema::create('vehicle_brands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('brand');
            $table->boolean('is_enable')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
