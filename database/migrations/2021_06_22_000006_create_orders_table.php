<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->string('total_price')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
