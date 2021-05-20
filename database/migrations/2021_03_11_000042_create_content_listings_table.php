<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentListingsTable extends Migration
{
    public function up()
    {
        Schema::create('content_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description');
            $table->boolean('pinned')->default(0)->nullable();
            $table->string('language');
            $table->string('created_by')->nullable();
            $table->string('send_to')->nullable();
            $table->string('url')->nullable();
            $table->string('user_group')->nullable();
            $table->string('expired_date')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
