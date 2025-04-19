<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            CREATE VIEW view_users_without_shops AS
            SELECT u.id, u.name, u.firstname, u.lastname, u.email, u.phone, u.address_street, u.address_city, u.address_state, u.address_zip_code, u.role, u.status, u.created_at
            FROM users u
            LEFT JOIN shops s ON u.id = s.user_id
            WHERE s.user_id IS NULL;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS view_users_without_shops");
    }
};
