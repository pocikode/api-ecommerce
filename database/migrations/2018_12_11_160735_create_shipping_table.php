<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # create shipping tables
        Schema::create('shippings', function (Blueprint $table) {
            $table->increments('shipping_id');
            $table->string('shipping_name');
            $table->unsignedInteger('customer_id');
            $table->string('received_name');
            $table->string('address', 250);
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('city_id');
            $table->integer('zip');
            $table->string('phone', 20);
            $table->boolean('default');
            $table->timestamps();
        });

        # set foreign key 
        Schema::table('shippings', function (Blueprint $table) {
            # foregin customer_id
            $table->foreign('customer_id')
                  ->references('customer_id')
                  ->on('customers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            # foreign province_id
            $table->foreign('province_id')
                  ->references('province_id')
                  ->on('provinces')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            # foreign city_id
            $table->foreign('city_id')
                  ->references('city_id')
                  ->on('cities')
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
        Schema::dropIfExists('shippings');
    }
}
