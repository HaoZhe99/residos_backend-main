<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('advance_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type')->nullable();
            $table->string('key')->nullable();
            $table->string('status')->nullable();
            $table->string('project_code')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
