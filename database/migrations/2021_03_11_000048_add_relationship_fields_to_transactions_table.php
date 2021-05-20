<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTransactionsTable extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('project_code_id')->nullable();
            $table->foreign('project_code_id', 'project_code_fk_3389422')->references('id')->on('project_listings');
            $table->unsignedBigInteger('bank_acc_id')->nullable();
            $table->foreign('bank_acc_id', 'bank_acc_fk_3389423')->references('id')->on('bank_acc_listings');
            $table->unsignedBigInteger('username_id');
            $table->foreign('username_id', 'username_fk_3389424')->references('id')->on('users');
        });
    }
}
