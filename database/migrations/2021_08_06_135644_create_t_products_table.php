<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('Category_ID');
            $table->string('Product_Name');
            $table->string('Product_Img')->nullable();
            $table->text('Product_Description')->nullable();
            $table->float('Product_Price', 12, 2);
            $table->boolean('Product_AvailableStatus');
            $table->boolean('Product_SystemStatus');
            $table->timestamps();
            $table->string('modified_user');
            
            $table->foreign('Category_ID')->references('id')->on('t_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_products');
    }
}
