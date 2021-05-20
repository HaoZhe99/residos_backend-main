<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackListingsTable extends Migration
{
    public function up()
    {
        Schema::create('feedback_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->longText('content');
            $table->string('send_to')->nullable();
            $table->string('reply')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
