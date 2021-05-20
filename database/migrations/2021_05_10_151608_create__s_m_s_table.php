<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('_s_m_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username');
            $table->string('secret_key');
            $table->timestamps();
        });
    }
}
