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
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('name');
            $table->text('address')->nullable();
            $table->unsignedInteger('city_id')->nullable();
            $table->unsignedInteger('province_id')->nullable();
            $table->string('zip')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password', 255);
            $table->string('photo', 255)->default('https://res.cloudinary.com/aguzs/image/upload/v1545460485/default-user-photo.png');
            $table->integer('point')->default(0);
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
        Schema::dropIfExists('customers');
    }
}
