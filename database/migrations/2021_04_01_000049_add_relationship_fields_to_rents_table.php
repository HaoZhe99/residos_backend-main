<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToRentsTable extends Migration
{
    public function up()
    {
        Schema::table('rents', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id')->nullable();
            $table->foreign('tenant_id', 'tenant_fk_3573667')->references('id')->on('users');
            $table->unsignedBigInteger('unit_owner_id');
            $table->foreign('unit_owner_id', 'unit_owner_fk_3573712')->references('id')->on('unit_mangements');
        });
    }
}
