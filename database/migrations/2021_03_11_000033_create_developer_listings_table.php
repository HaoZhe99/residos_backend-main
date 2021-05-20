<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeveloperListingsTable extends Migration
{
    public function up()
    {
        Schema::create('developer_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('fb')->nullable();
            $table->string('linked_in')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
