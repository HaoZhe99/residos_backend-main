<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectListingsTable extends Migration
{
    public function up()
    {
        Schema::create('project_listings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('address');
            $table->string('tenure');
            $table->string('completion_date');
            $table->string('status');
            $table->string('sales_gallery')->nullable();
            $table->string('website')->nullable();
            $table->string('fb')->nullable();
            $table->integer('block')->nullable();
            $table->integer('unit')->nullable();
            $table->string('project_code')->nullable();
            $table->boolean('is_new')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
