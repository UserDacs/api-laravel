<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_v2_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('customer_id');
            $table->dateTime('booking_date')->nullable();
            $table->string('booking_address');
            $table->string('booking_duration')->nullable();
            $table->decimal('booking_lat', 10, 7)->nullable();
            $table->decimal('booking_long', 10, 7)->nullable();
            $table->enum('booking_status', ['pending', 'cancel', 'done'])->default('pending');
            $table->enum('payment_method', ['cash', 'card', 'online'])->default('cash');
            $table->timestamps();

            $table->foreign('service_id')->references('id')->on('service_v2_s')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_v2_s');
    }
};
