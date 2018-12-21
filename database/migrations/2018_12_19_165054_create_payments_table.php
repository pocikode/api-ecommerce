<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('order_id');
            $table->string('invoice')->unique();
            $table->string('to_bank');
            $table->string('bank_name');
            $table->string('account_name');
            $table->string('account_number');
            $table->bigInteger('amount');
            $table->date('date');
            $table->enum('status', ['unconfirmed', 'confirmed'])->default('unconfirmed');
            $table->timestamps();

            # foreign customer
            $table->foreign('customer_id')->references('customer_id')->on('customers')->onUpdate('cascade')->onDelete('cascade');

            # foreign order
            $table->foreign('order_id')->references('order_id')->on('orders')->onUpdate('cascade')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
