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
        Schema::table('service_v2_s', function (Blueprint $table) {
            $table->text('image_path')->nullable(); // Add image_path column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_v2_s', function (Blueprint $table) {
            $table->dropColumn('image_path'); // Remove image_path column if migration is rolled back
        });
    }
};
