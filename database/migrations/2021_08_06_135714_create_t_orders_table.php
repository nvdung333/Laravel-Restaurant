<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('User_ID')->nullable();
            $table->string('Customer_Name');
            $table->string('Customer_Phone');
            $table->string('Customer_Email')->nullable();
            $table->string('Customer_Address');
            
            $table->foreignId('Restaurant_ID')->nullable();
            $table->string('Restaurant_Staff');
            $table->string('Order_RestaurantName');
            
            $table->integer('Order_TotalProducts');
            $table->float('Order_TotalPrice', 15, 2);
            $table->text('Order_Note')->nullable();
            
            $table->tinyInteger('Order_Status');
            $table->string('Order_CancelBy')->nullable();
            $table->text('Order_CancelReason')->nullable();
            $table->text('Order_ReturnReason')->nullable();
            
            $table->dateTime('Order_Time_Request')->nullable();
            $table->dateTime('Order_Time_Accept')->nullable();
            $table->dateTime('Order_Time_Complete')->nullable();
            $table->dateTime('Order_Time_Receive')->nullable();
            $table->dateTime('Order_Time_Cancel')->nullable();
            $table->dateTime('Order_Time_Return')->nullable();
            
            $table->timestamps();
            $table->string('created_user');
            $table->string('modified_user');
            
            $table->foreign('User_ID')->references('id')->on('users')
            ->onUpdate('cascade')->onDelete('set null');
            
            $table->foreign('Restaurant_ID')->references('id')->on('t_restaurants')
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
        Schema::dropIfExists('t_orders');
    }
}
