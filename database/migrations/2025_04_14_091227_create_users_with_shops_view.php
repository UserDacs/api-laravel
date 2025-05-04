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
            CREATE VIEW view_users_with_shops AS
            SELECT
                users.id AS user_id,
                users.name,
                users.firstname,
                users.lastname,
                users.email,
                users.role,
                users.status,
                users.phone,
                users.address_street,
                users.address_city,
                users.address_state,
                users.address_zip_code,
                users.image_path,
                users.mobile_auth,
                shops.id AS shop_id,
                shops.shop_name,
                shops.shop_address,
                shops.shop_details,
                shops.status AS shop_status,
                shops.shop_lat,
                shops.shop_long,
                shops.shop_image,
                shops.shop_national_id,
                shops.cor,
                shops.created_at AS shop_created_at,
                shops.updated_at AS shop_updated_at
            FROM
                users
            JOIN
                shops ON users.id = shops.user_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_users_with_shops");
    }
};
