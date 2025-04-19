<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared("

        -- Procedure: rate_service
        DROP PROCEDURE IF EXISTS rate_service;
        CREATE PROCEDURE rate_service(
            IN _service_id BIGINT,
            IN _user_id BIGINT,
            IN _rating TINYINT
        )
        BEGIN
            IF _rating >= 1 AND _rating <= 5 THEN
                INSERT INTO service_ratings (service_id, user_id, rating, created_at, updated_at)
                VALUES (_service_id, _user_id, _rating, NOW(), NOW());
            END IF;
        END;

        -- Procedure: rate_shop
        DROP PROCEDURE IF EXISTS rate_shop;
        CREATE PROCEDURE rate_shop(
            IN _shop_id BIGINT,
            IN _user_id BIGINT,
            IN _rating TINYINT
        )
        BEGIN
            IF _rating >= 1 AND _rating <= 5 THEN
                INSERT INTO shop_ratings (shop_id, user_id, rating, created_at, updated_at)
                VALUES (_shop_id, _user_id, _rating, NOW(), NOW());
            END IF;
        END;

        -- Procedure: rate_technician
        DROP PROCEDURE IF EXISTS rate_technician;
        CREATE PROCEDURE rate_technician(
            IN _technician_id BIGINT,
            IN _user_id BIGINT,
            IN _rating TINYINT
        )
        BEGIN
            IF _rating >= 1 AND _rating <= 5 THEN
                INSERT INTO technician_ratings (technician_id, user_id, rating, created_at, updated_at)
                VALUES (_technician_id, _user_id, _rating, NOW(), NOW());
            END IF;
        END;

        -- Procedure: add_service_comment
        DROP PROCEDURE IF EXISTS add_service_comment;
        CREATE PROCEDURE add_service_comment(
            IN _service_id BIGINT,
            IN _user_id BIGINT,
            IN _comment TEXT
        )
        BEGIN
            INSERT INTO service_comments (service_id, user_id, comment, created_at, updated_at)
            VALUES (_service_id, _user_id, _comment, NOW(), NOW());
        END;

        -- Procedure: reply_to_service_comment
        DROP PROCEDURE IF EXISTS reply_to_service_comment;
        CREATE PROCEDURE reply_to_service_comment(
            IN _comment_id BIGINT,
            IN _user_id BIGINT,
            IN _reply TEXT
        )
        BEGIN
            INSERT INTO service_comment_replies (comment_id, user_id, reply, created_at, updated_at)
            VALUES (_comment_id, _user_id, _reply, NOW(), NOW());
        END;

        -- View: service_average_ratings
        DROP VIEW IF EXISTS service_average_ratings;
        CREATE VIEW service_average_ratings AS
        SELECT
            service_id,
            ROUND(AVG(rating), 2) AS average_rating,
            COUNT(*) AS total_reviews
        FROM service_ratings
        GROUP BY service_id;

        ");
    }

    public function down(): void
    {
        DB::unprepared("
            DROP PROCEDURE IF EXISTS rate_service;
            DROP PROCEDURE IF EXISTS rate_shop;
            DROP PROCEDURE IF EXISTS rate_technician;
            DROP PROCEDURE IF EXISTS add_service_comment;
            DROP PROCEDURE IF EXISTS reply_to_service_comment;
            DROP VIEW IF EXISTS service_average_ratings;
        ");
    }
};
