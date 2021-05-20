<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorControlsTable extends Migration
{
    public function up()
    {
        Schema::create('visitor_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status');
            $table->boolean('favourite')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
