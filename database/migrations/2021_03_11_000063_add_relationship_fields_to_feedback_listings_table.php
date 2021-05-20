<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFeedbackListingsTable extends Migration
{
    public function up()
    {
        Schema::table('feedback_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id', 'category_fk_3270376')->references('id')->on('feedback_categories');
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3339972')->references('id')->on('project_listings');
            $table->unsignedBigInteger('created_by_id');
            $table->foreign('created_by_id', 'created_by_fk_3456727')->references('id')->on('users');
        });
    }
}
