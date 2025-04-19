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
    public function up()
    {
        DB::statement("
            CREATE OR REPLACE VIEW view_technicians AS
            SELECT
                t.id AS technician_id,
                u.id AS user_id,
                u.name,
                u.firstname,
                u.lastname,
                u.email,
                u.status,
                u.phone,
                u.image_path,
                s.id AS shop_id,
                s.shop_name,
                s.shop_address,
                s.shop_lat,
                s.shop_long,
                t.created_at AS technician_created_at,
                t.updated_at AS technician_updated_at
            FROM
                technicians t
            LEFT JOIN users u ON u.id = t.user_id
            LEFT JOIN shops s ON s.id = t.shop_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_technicians");
    }
};
