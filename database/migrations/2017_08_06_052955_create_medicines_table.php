<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('batch');
            $table->string('type');
            $table->string('name');
            $table->integer('componet');
            $table->integer('concentration');
            $table->date('expiration_date');
            $table->date('production_date');
            $table->text('description');
            $table->integer('stock');
            $table->decimal('purchanse_price',3,2);
            $table->decimal('sale_price',3,2);
            $table->decimal('igv',3,2);

            $table->foreign('presentation')->references('name')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}
