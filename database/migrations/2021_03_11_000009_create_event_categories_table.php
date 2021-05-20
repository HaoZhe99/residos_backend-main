<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('event_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cateogey');
            $table->boolean('is_enable')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
