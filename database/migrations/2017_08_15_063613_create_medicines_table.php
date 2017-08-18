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
            $table->string('name');
            $table->text('description');
            $table->integer('presentation_id')->unsigned()->nullable();
            $table->foreign('presentation_id')
                  ->references('id')->on('presentations')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('type');
            $table->integer('component');
            $table->string('concentration');
            $table->integer('stock');
            $table->float('purchanse_price');
            $table->float('sale_price');
            $table->float('igv');
            $table->date('expiration_date');
            $table->date('production_date');
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
