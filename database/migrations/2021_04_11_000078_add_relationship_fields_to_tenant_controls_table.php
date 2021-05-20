<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTenantControlsTable extends Migration
{
    public function up()
    {
        Schema::table('tenant_controls', function (Blueprint $table) {
            $table->unsignedBigInteger('tenant_id');
            $table->foreign('tenant_id', 'tenant_fk_2905560')->references('id')->on('users');
            $table->unsignedBigInteger('rent_id');
            $table->foreign('rent_id', 'rent_fk_2969203')->references('id')->on('rents');
        });
    }
}
