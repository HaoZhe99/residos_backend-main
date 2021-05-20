<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBankAccListingsTable extends Migration
{
    public function up()
    {
        Schema::table('bank_acc_listings', function (Blueprint $table) {
            $table->unsignedBigInteger('bank_name_id')->nullable();
            $table->foreign('bank_name_id', 'bank_name_fk_3378962')->references('id')->on('bank_names');
            $table->unsignedBigInteger('project_code_id')->nullable();
            $table->foreign('project_code_id', 'project_code_fk_3392515')->references('id')->on('project_listings');
        });
    }
}
