<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToGateHistoriesTable extends Migration
{
    public function up()
    {
        Schema::table('gate_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('username_id');
            $table->foreign('username_id', 'username_fk_3380969')->references('id')->on('users');
            $table->unsignedBigInteger('gateway_id');
            $table->foreign('gateway_id', 'gateway_fk_2908963')->references('id')->on('gateways');
            $table->unsignedBigInteger('qr_id')->nullable();
            $table->foreign('qr_id', 'qr_fk_2959146')->references('id')->on('qrs');
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id', 'unit_fk_3079931')->references('id')->on('unit_mangements');
        });
    }
}
