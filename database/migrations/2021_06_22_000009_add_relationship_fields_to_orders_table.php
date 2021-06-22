<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('carpet_id')->nullable();
            $table->foreign('carpet_id', 'carpet_fk_4218598')->references('id')->on('carpets');
        });
    }
}
