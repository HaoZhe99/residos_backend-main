<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('content_listing_user', function (Blueprint $table) {
            $table->unsignedBigInteger('content_listing_id');
            $table->foreign('content_listing_id', 'content_listing_id_fk_2905161')->references('id')->on('content_listings')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_2905199')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('read')->default(0);
        });
    }
}
