<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEBillListingsTable extends Migration
{
    public function up()
    {
        Schema::table('e_bill_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id', 'project_fk_3337473')->references('id')->on('project_listings');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_3337475')->references('id')->on('unit_mangements');
            $table->unsignedBigInteger('bank_acc_id')->nullable();
            $table->foreign('bank_acc_id', 'bank_acc_fk_3378790')->references('id')->on('bank_acc_listings');
            $table->unsignedBigInteger('username_id')->nullable();
            $table->foreign('username_id', 'username_fk_3378791')->references('id')->on('users');
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id', 'username_fk_3378899')->references('id')->on('payment_methods');
        });
    }
}
