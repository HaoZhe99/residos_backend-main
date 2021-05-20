<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermAndPoliciesTable extends Migration
{
    public function up()
    {
        Schema::create('term_and_policies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('title_zh');
            $table->string('title_en');
            $table->string('title_ms');
            $table->longText('details_zh');
            $table->longText('details_en');
            $table->longText('details_ms');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
