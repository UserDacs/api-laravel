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
    public function up() {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();  // Booking Tracking Number
            $table->date('booking_date');                 // Booking Date
            $table->text('booking_details')->nullable();  // Booking Details
            $table->string('booking_location');           // Booking Location
            $table->enum('payment_method', ['cash', 'card', 'online'])->default('cash');  // Payment Method
            $table->decimal('total_price', 10, 2);        // Total Price

            // Foreign keys
            $table->unsignedBigInteger('service_id');     // Service being booked
            $table->unsignedBigInteger('user_id');        // User who booked
            $table->unsignedBigInteger('owner_id');       // Service Owner
            
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('bookings');
    }
};
