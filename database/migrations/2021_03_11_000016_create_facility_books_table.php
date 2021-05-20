<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacilityBooksTable extends Migration
{
    public function up()
    {
        Schema::create('facility_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->time('time');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
