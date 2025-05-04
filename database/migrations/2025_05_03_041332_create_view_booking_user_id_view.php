<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        DB::statement("
            CREATE VIEW view_booking_user_id AS
            SELECT sv.id AS service_id, s.user_id
            FROM service_v2_s sv
            JOIN shops s ON sv.shop_id = s.id
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_booking_user_id");
    }
};
