<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefectCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('defect_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('defect_cateogry');
            $table->boolean('in_enable')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
