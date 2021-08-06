<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOrderdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_orderdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Order_ID')->nullable();
            $table->foreignId('Product_ID')->nullable();
            $table->string('OrderDetail_ProductName');
            $table->integer('OrderDetail_Quantity');
            $table->float('OrderDetail_Price', 12, 2);
            $table->text('OrderDetail_Note')->nullable();
            $table->boolean('OrderDetail_Status');
            $table->timestamps();
            $table->string('modified_user');
            
            $table->foreign('Order_ID')->references('id')->on('t_orders')
            ->onUpdate('cascade')->onDelete('cascade');
            
            $table->foreign('Product_ID')->references('id')->on('t_products')
            ->onUpdate('cascade')->onDelete('set null');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_orderdetails');
    }
}
