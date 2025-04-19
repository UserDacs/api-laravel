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
            CREATE VIEW shop_with_services_json AS
            SELECT
                s.id AS shop_id,
                s.shop_name,
                s.shop_address,
                s.shop_details,
                s.shop_lat,
                s.shop_long,
                JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'id', sv.id,
                        'service_name', IF(CHAR_LENGTH(sv.service_name) > 15, CONCAT(LEFT(sv.service_name, 15), '...'), sv.service_name),
                        'price', sv.price,
                        'description', sv.description,
                        'status', sv.status,
                        'image_path', sv.image_path
                    )
                ) AS services
            FROM shops s
            LEFT JOIN service_v2_s sv ON sv.shop_id = s.id
            GROUP BY
                s.id,
                s.shop_name,
                s.shop_address,
                s.shop_details,
                s.shop_lat,
                s.shop_long
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS shop_with_services_json");
    }

};
