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
            CREATE VIEW view_user_services_comments_ratings AS
            SELECT 
                u.id AS user_id,
                u.name AS user_name,
                u.email,
                u.role,
                u.status,
                u.phone,
                u.address_street,
                u.address_city,
                u.address_state,
                u.address_zip_code,
                u.image_path,
                u.mobile_auth,
                s.id AS service_id,
                s.name AS service_name,
                s.description AS service_description,
                s.service_fee,
                s.photo_path AS service_photo,
                s.is_public,
                s.created_at AS service_created_at,
                s.updated_at AS service_updated_at,
                c.id AS comment_id,
                c.parent_id AS comment_parent_id,
                c.comment AS comment_text,
                c.created_at AS comment_created_at,
                c.updated_at AS comment_updated_at,
                c.user_id AS comment_user_id,
                r.rating AS service_rating
            FROM 
                users u
            INNER JOIN 
                services s ON u.id = s.user_id
            LEFT JOIN 
                comments c ON s.id = c.service_id
            LEFT JOIN 
                ratings r ON s.id = r.service_id
            WHERE 
                s.is_public = 1;
        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_user_services_comments_ratings");
    }
};
