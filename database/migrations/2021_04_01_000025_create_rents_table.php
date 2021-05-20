<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('rent_fee');
            $table->string('day_of_month')->nullable();
            $table->integer('leases')->nullable();
            $table->string('bank_acc');
            $table->string('status');
            $table->string('type');
            $table->integer('slot_limit');
            $table->float('room_size', 15, 2)->nullable();
            $table->string('remark')->nullable();
            $table->datetime('start_rent_day')->nullable();
            $table->datetime('end_rent_day')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
