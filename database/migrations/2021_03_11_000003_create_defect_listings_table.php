<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectListingsTable extends Migration
{
    public function up()
    {
        Schema::create('defect_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('remark')->nullable();
            $table->string('incharge_person')->nullable();
            $table->string('case_code');
            $table->string('contractor')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
