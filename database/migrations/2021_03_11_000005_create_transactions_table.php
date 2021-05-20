<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bill_code');
            $table->string('credit')->nullable();
            $table->string('debit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
