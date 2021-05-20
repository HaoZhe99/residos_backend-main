<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarparklocationsTable extends Migration
{
    public function up()
    {
        Schema::create('carparklocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location');
            $table->boolean('is_enable')->default(0)->nullable();
            $table->string('location_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
