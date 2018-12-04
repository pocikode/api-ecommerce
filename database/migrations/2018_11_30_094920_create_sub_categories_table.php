<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->increments('sub_category_id');
            $table->unsignedInteger('category_id');
            $table->string('name');
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('categories')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
