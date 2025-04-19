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
            CREATE OR REPLACE VIEW full_service_view AS
            SELECT
                s.id AS service_id,
                s.service_name,
                s.price,
                s.description AS service_description,
                s.status AS service_status,
                s.image_path AS service_image_path,
                DATE_FORMAT(s.created_at, '%M %e, %Y %l:%i %p') AS service_created_at,

                (SELECT COUNT(*) FROM booking_v2_s bs WHERE bs.booking_status = 'done' AND bs.service_id = s.id) AS  service_client,

                -- Latest service rating (1 latest review per service)
                srs.id AS service_rate_id,
                srs.user_id AS service_rate_user_id,
                srs.rating AS service_rate,
                DATE_FORMAT(srs.created_at, '%M %e, %Y %l:%i %p') AS service_rate_created_at,

                -- Aggregated rating data
                agg.average_rating,
                agg.total_reviews,

                -- Shop details
                sh.id AS shop_id,
                sh.shop_name,
                sh.shop_address,
                sh.shop_lat,
                sh.shop_long,

                -- Technician details
                t.id AS technician_id,

                -- Technician user details
                tu.id AS technician_user_id,
                tu.name AS technician_fullname,
                tu.firstname AS technician_firstname,
                tu.lastname AS technician_lastname,
                tu.email AS technician_email,
                tu.phone AS technician_phone,

                -- Shop owner details
                su.id AS shop_owner_id,
                su.name AS shop_owner_fullname,
                su.firstname AS shop_owner_firstname,
                su.lastname AS shop_owner_lastname,
                su.email AS shop_owner_email,
                su.status AS shop_owner_user_status,

                -- Category details
                c.id AS category_id,
                c.category_name,
                c.description AS category_description

            FROM service_v2_s s

            -- Shop
            JOIN shops sh ON s.shop_id = sh.id

            -- Shop Owner (User who owns the shop)
            JOIN users su ON sh.user_id = su.id

            -- Technician
            JOIN technicians t ON s.technician_id = t.id

            -- Technician user
            JOIN users tu ON t.user_id = tu.id

            -- Category
            JOIN categories c ON s.category_id = c.id

            -- Latest rating per service
            LEFT JOIN (
                SELECT sr1.*
                FROM service_ratings sr1
                JOIN (
                    SELECT service_id, MAX(created_at) AS max_created_at
                    FROM service_ratings
                    GROUP BY service_id
                ) sr2 ON sr1.service_id = sr2.service_id AND sr1.created_at = sr2.max_created_at
            ) srs ON srs.service_id = s.id

            -- Aggregate rating per service
            LEFT JOIN (
                SELECT
                    service_id,
                    ROUND(AVG(rating), 2) AS average_rating,
                    COUNT(id) AS total_reviews
                FROM service_ratings
                GROUP BY service_id
            ) agg ON agg.service_id = s.id;

                    ");
        DB::statement("
            CREATE VIEW `view_service_feedback` AS
            SELECT
                us.`name`,
                CONCAT(us.firstname,' ', us.lastname) AS fullname,
                us.image_path,
                sc.id AS comment_id,
                sc.service_id,
                sc.user_id,
                sc.comment,
                sr.id AS rating_id,
                sr.rating,
                DATE_FORMAT(sc.created_at, '%M %e, %Y %l:%i %p') AS comment_created_at,
                sr.created_at AS rating_created_at
            FROM
                service_comments sc
            JOIN users us
                ON us.id = sc.user_id
            LEFT JOIN
                service_ratings sr
                ON sc.service_id = sr.service_id AND sc.user_id = sr.user_id;
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS full_service_view");
        DB::statement("DROP VIEW IF EXISTS view_service_feedback");
    }

};
