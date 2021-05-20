<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddBlocksTable extends Migration
{
    public function up()
    {
        Schema::create('add_blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('block');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
