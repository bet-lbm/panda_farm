<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sales_id')->unsigned();
            $table->foreign('sales_id')->references('id')->on('sales')->onUpdate('cascade');
            //$table->string('sale_series',5);
            //$table->string('sale_number',7);
           // $table->foreign(array('sale_series','sale_number'))->references(array('series','number'))->on('sales')->onUpdate('cascade');
            $table->integer('medicine_id')->unsigned();
            $table->foreign('medicine_id')->references('id')->on('medicines')->onUpdate('cascade');
            $table->string('medicine_name')->references('name')->on('medicines')->onUpdate('cascade');
            $table->integer('quantity');
            $table->float('sale_price');
            $table->float('discount')->nullable();
            $table->float('subtotal');
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
        Schema::dropIfExists('sale_details');
    }
}
