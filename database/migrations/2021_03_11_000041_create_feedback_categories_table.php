<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('feedback_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category');
            $table->boolean('is_active')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
