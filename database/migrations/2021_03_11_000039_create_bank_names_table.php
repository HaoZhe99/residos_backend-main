<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankNamesTable extends Migration
{
    public function up()
    {
        Schema::create('bank_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country');
            $table->string('bank_name');
            $table->string('swift_code')->nullable();
            $table->string('bank_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
