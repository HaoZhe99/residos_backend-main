<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventListingsTable extends Migration
{
    public function up()
    {
        Schema::create('event_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_code');
            $table->string('title');
            $table->string('description');
            $table->string('language');
            $table->string('payment')->nullable();
            $table->integer('participants')->nullable();
            $table->string('organized_by')->nullable();
            $table->string('type')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
