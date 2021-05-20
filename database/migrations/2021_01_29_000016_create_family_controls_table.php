<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyControlsTable extends Migration
{
    public function up()
    {
        Schema::create('family_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('activity_logs');
            $table->boolean('from_family')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
