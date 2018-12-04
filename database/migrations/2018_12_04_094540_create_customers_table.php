<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('customers', function (Blueprint $table) {
        //     $table->increments('customer_id');
        //     $table->string('name');
        //     $table->string('address', 256)->nullable();
        //     $table->unsignedInteger('city_id')->nullable();
        //     $table->unsignedInteger('province_id')->nullable();
        //     $table->integer('zip')->nullable();
        //     $table->string('phone', 50);
        //     $table->string('email', 100);
        //     $table->string('password', 255);
        //     $table->string('photo', 100)->nullable();
        //     $table->integer('point');

        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('customers');
    }
}
