<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_categories', function (Blueprint $table) {
            $table->id();
            $table->string('Category_Name');
            $table->string('slug')->nullable();
            $table->string('Category_Img')->nullable();
            $table->text('Category_Description')->nullable();
            $table->foreignId('Category_Parent_ID')->nullable();
            $table->timestamps();
            $table->string('modified_user');
            
            $table->foreign('Category_Parent_ID')->references('id')->on('t_categories');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_categories');
    }
}
