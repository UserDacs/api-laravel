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
        Schema::table('shops', function (Blueprint $table) {
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending')->after('shop_long');
            $table->text('shop_image')->nullable()->after('status');
            $table->text('shop_national_id')->nullable()->after('shop_image');
            $table->text('cor')->nullable()->after('shop_national_id');
        });
    }

    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['status', 'shop_image', 'shop_national_id', 'cor']);
        });
    }
};
