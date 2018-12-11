<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('code');
            $table->string('name', 255);
            $table->unsignedInteger('category_id');
            $table->string('category_name');
            $table->unsignedInteger('sub_category_id');
            $table->string('sub_category_name');
            $table->unsignedInteger('brand_id')->nullable();
            $table->integer('point')->default(0);
            $table->integer('price');
            $table->integer('weight');
            $table->string('image');
            $table->text('description');
            $table->string('sizes');
            $table->integer('sold')->default(0);
            $table->integer('hit_views')->default(0);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('products');
    }
}
