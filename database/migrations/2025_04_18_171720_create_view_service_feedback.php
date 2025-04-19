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
        DB::statement("DROP VIEW IF EXISTS view_service_feedback");
    }

};
