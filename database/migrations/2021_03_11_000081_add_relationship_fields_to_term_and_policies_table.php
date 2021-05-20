<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTermAndPoliciesTable extends Migration
{
    public function up()
    {
        Schema::table('term_and_policies', function (Blueprint $table) {
            $table->unsignedBigInteger('project_code_id');
            $table->foreign('project_code_id', 'project_code_fk_3380580')->references('id')->on('project_listings');
        });
    }
}
