<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccListingsTable extends Migration
{
    public function up()
    {
        Schema::create('bank_acc_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bank_account');
            $table->string('status')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->decimal('balance', 15, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
