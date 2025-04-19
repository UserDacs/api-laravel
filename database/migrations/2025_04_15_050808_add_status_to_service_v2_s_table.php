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
            $table->enum('status', ['active', 'inactive'])
                  ->default('active')
                  ->after('description');
        });
    }

    public function down()
    {
        Schema::table('service_v2_s', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
