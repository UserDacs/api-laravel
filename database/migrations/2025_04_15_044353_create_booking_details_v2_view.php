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
            CREATE VIEW booking_details_v2 AS
            SELECT
                b.id AS booking_id,
                b.booking_date,
                b.booking_status,
                b.payment_method,
                b.booking_address,
                b.booking_duration,
                b.booking_lat,
                b.booking_long,
                b.created_at AS booking_created_at,
                b.updated_at AS booking_updated_at,

                -- Customer Info
                c.id AS customer_id,
                c.name AS fullname,
                c.firstname AS customer_firstname,
                c.lastname AS customer_lastname,
                c.email AS customer_email,
                c.phone AS customer_phone,

                -- Service Info
                s.id AS service_id,
                s.service_name,
                s.image_path AS service_image_path,
                s.price AS service_price,
                s.description AS service_description,
                s.status AS service_status,

                -- Category Info
                cat.id AS category_id,
                cat.category_name,
                cat.description AS category_description,

                -- Technician Info
                t.id AS technician_id,
                utech.firstname AS technician_firstname,
                utech.lastname AS technician_lastname,
                utech.email AS technician_email,

                -- Shop Info
                shop.id AS shop_id,
                shop.shop_name,
                shop.shop_address,
                shop.shop_lat,
                shop.shop_long

            FROM booking_v2_s b
            LEFT JOIN users c ON b.customer_id = c.id
            LEFT JOIN service_v2_s s ON b.service_id = s.id
            LEFT JOIN categories cat ON s.category_id = cat.id
            LEFT JOIN technicians t ON s.technician_id = t.id
            LEFT JOIN users utech ON t.user_id = utech.id
            LEFT JOIN shops shop ON s.shop_id = shop.id;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS booking_details_v2");
    }
};
