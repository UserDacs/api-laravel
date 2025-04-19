<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW unified_ratings_view AS
            -- ✅ SERVICE RATINGS
            SELECT
                'service' AS type,
                MAX(sr.id) AS rating_id,
                ROUND(AVG(sr.rating), 2) AS average_rating,
                COUNT(sr.id) AS total_reviews,
                sr.service_id AS reference_id,
                sc.service_name,
                sp.shop_name AS shop_name,
                ut.name AS fullname,
                MAX(sr.user_id) AS user_id,
                MAX(sr.rating) AS rating,
                MAX(sr.created_at) AS created_at,
                sp.id AS shop_id,
                tech.id AS technician_id
            FROM service_ratings sr
            LEFT JOIN service_v2_s sc ON sr.service_id = sc.id
            LEFT JOIN shops sp ON sp.id = sc.shop_id
            LEFT JOIN technicians tech ON tech.id = sc.technician_id
            LEFT JOIN users ut ON ut.id = tech.user_id
            GROUP BY sr.service_id, sc.service_name, sp.shop_name, ut.name, sp.id, tech.id

            UNION

            -- ✅ SHOP RATINGS
            SELECT
                'shop' AS type,
                MAX(shr.id) AS rating_id,
                ROUND(AVG(shr.rating), 2) AS average_rating,
                COUNT(shr.id) AS total_reviews,
                shr.shop_id AS reference_id,
                sp.shop_name AS service_name,
                sp.shop_name AS shop_name,
                NULL AS fullname,
                MAX(shr.user_id) AS user_id,
                MAX(shr.rating) AS rating,
                MAX(shr.created_at) AS created_at,
                shr.shop_id,
                NULL AS technician_id
            FROM shop_ratings shr
            LEFT JOIN shops sp ON sp.id = shr.shop_id
            GROUP BY shr.shop_id, sp.shop_name

            UNION

            -- ✅ TECHNICIAN RATINGS
            SELECT
                'technician' AS type,
                MAX(tr.id) AS rating_id,
                ROUND(AVG(tr.rating), 2) AS average_rating,
                COUNT(tr.id) AS total_reviews,
                tr.technician_id AS reference_id,
                ut.name AS service_name,
                sp.shop_name AS shop_name,
                ut.name AS fullname,
                MAX(tr.user_id) AS user_id,
                MAX(tr.rating) AS rating,
                MAX(tr.created_at) AS created_at,
                tech.shop_id,
                tr.technician_id
            FROM technician_ratings tr
            LEFT JOIN technicians tech ON tech.id = tr.technician_id
            LEFT JOIN shops sp ON sp.id = tech.shop_id
            LEFT JOIN users ut ON ut.id = tech.user_id
            GROUP BY tr.technician_id, ut.name, sp.shop_name, tech.shop_id;
        ");

        DB::statement("CREATE OR REPLACE VIEW service_comments_view AS
            SELECT
                uc.name As fullname,
                sc.id AS comment_id,
                sc.service_id,
                (SELECT ROUND(AVG(service_ratings.rating), 2) FROM service_ratings WHERE service_ratings.user_id = sc.user_id AND service_ratings.service_id = sc.service_id) AS average_rating,
                sc.user_id,
                sc.comment,
                sc.created_at,
                sc.updated_at
            FROM service_comments sc
            LEFT JOIN users uc ON uc.id = sc.user_id
            ;
        ");

        DB::statement("CREATE OR REPLACE VIEW service_comment_replies_view AS
            SELECT
                uc.name As fullname,
                scr.id AS reply_id,
                scr.comment_id,
                scr.user_id,
                scr.reply,
                scr.created_at,
                scr.updated_at
            FROM service_comment_replies scr
            LEFT JOIN users uc ON uc.id = scr.user_id;
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS unified_ratings_view");
        DB::statement("DROP VIEW IF EXISTS service_comments_view");
        DB::statement("DROP VIEW IF EXISTS service_comment_replies_view");
    }
};
