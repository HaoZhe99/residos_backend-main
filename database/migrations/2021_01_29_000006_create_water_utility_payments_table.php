<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWaterUtilityPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('water_utility_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->date('last_date')->nullable();
            $table->integer('last_meter');
            $table->integer('this_meter');
            $table->integer('prev_consume');
            $table->integer('this_consume');
            $table->integer('variance');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
