<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticeBoardsTable extends Migration
{
    public function up()
    {
        Schema::create('notice_boards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('post_at');
            $table->string('post_to');
            $table->integer('pinned')->nullable();
            $table->string('status')->nullable();
            $table->string('post_by')->nullable();
            $table->string('title_zh');
            $table->string('title_en');
            $table->string('title_ms');
            $table->longText('content_zh');
            $table->longText('content_en');
            $table->longText('content_ms');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
