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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin', 'provider','customer'])->default('user'); // Enum for role
            $table->enum('status', ['active', 'inactive'])->default('active');    // Enum for status
            $table->string('phone')->nullable();
            $table->string('address_street')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_state')->nullable();
            $table->string('address_zip_code')->nullable();
            $table->text('image_path')->nullable();
            $table->enum('mobile_auth', ['authenticated', 'unauthenticated'])->default('unauthenticated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'address_street')) {
                $table->dropColumn('address_street');
            }
            if (Schema::hasColumn('users', 'address_city')) {
                $table->dropColumn('address_city');
            }
            if (Schema::hasColumn('users', 'address_state')) {
                $table->dropColumn('address_state');
            }
            if (Schema::hasColumn('users', 'address_zip_code')) {
                $table->dropColumn('address_zip_code');
            }
            if (Schema::hasColumn('users', 'image_path')) {
                $table->dropColumn('image_path');
            }
            if (Schema::hasColumn('users', 'mobile_auth')) {
                $table->dropColumn('mobile_auth');
            }
        });
    }
};
