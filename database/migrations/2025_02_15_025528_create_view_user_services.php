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
            CREATE VIEW view_user_services_provider AS
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
                s.updated_at AS service_updated_at
            FROM 
                users u
            INNER JOIN 
                services s ON u.id = s.user_id;
        ");

        DB::unprepared('
            CREATE PROCEDURE get_user_services_provider(IN userId INT)
            BEGIN
                SELECT 
                    user_id,
                    user_name,
                    email,
                    role,
                    status,
                    phone,
                    address_street,
                    address_city,
                    address_state,
                    address_zip_code,
                    image_path,
                    mobile_auth,
                    service_id,
                    service_name,
                    service_description,
                    service_fee,
                    service_photo,
                    is_public,
                    service_created_at,
                    service_updated_at
                FROM 
                    view_user_services_provider
                WHERE 
                    user_id = userId;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_user_services_provider");

        DB::unprepared('DROP PROCEDURE IF EXISTS get_user_services_provider');
    }
};
