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
        Schema::create('technician_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('user_id');
            $table->tinyInteger('rating')->unsigned(); // 1 to 5
            $table->timestamps();

            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('technician_ratings');
    }
};
