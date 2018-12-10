<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cart_id');
            $table->unsignedInteger('product_id');
            $table->string('product_name');
            $table->string('size');
            $table->integer('price');
            $table->timestamps();
        });

        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreign('cart_id')
                  ->references('cart_id')
                  ->on('carts')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('product_id')
                  ->on('products')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}
