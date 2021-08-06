<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('Restaurant_Name');
            $table->string('Restaurant_Address');
            $table->string('Restaurant_Area')->nullable();
            $table->string('Restaurant_Phone')->nullable();
            $table->text('Restaurant_Description')->nullable();
            $table->boolean('Restaurant_OpenStatus');
            $table->boolean('Restaurant_SystemStatus');
            $table->timestamps();
            $table->string('modified_user');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_restaurants');
    }
}
