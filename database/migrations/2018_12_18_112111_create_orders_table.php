<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('order_id');
            $table->string('invoice')->unique();
            $table->unsignedInteger('customer_id');
            $table->bigInteger('amount');
            $table->integer('shipping_cost');
            $table->bigInteger('total_payment');
            $table->string('received_name');
            $table->string('address');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('city_id');
            $table->integer('zip');
            $table->string('phone');
            $table->dateTime('due_date');
            $table->string('awb', 25)->nullable();
            $table->enum('status', ['unpaid', 'unconfirmed', 'confirmed', 'rejected', 'shipped', 'success'])->default('unpaid');
            $table->timestamps();

            # foreign customer
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onUpdate('cascade')->onDelete('cascade');

            # foreign province
            $table->foreign('province_id')->references('province_id')->on('provinces')->onUpdate('cascade')->onDelete('cascade');

            # foreign city
            $table->foreign('city_id')->references('city_id')->on('cities')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
