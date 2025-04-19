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
        DB::statement("CREATE OR REPLACE VIEW user_conversations_view AS
                SELECT
                        u.id,
                        u.name,
                        u.image_path,
                        u.role,
                        MAX(m.created_at) AS latest_message_time,
                        MAX(m.message) AS latest_message,
                        MAX(m.is_read) AS is_read
                    FROM messages m
                    JOIN users u ON u.id = m.receiver_id
                    WHERE m.sender_id != m.receiver_id
                    GROUP BY u.id, u.name, u.image_path, u.role

                    UNION

                    SELECT
                        u.id,
                        u.name,
                        u.image_path,
                        u.role,
                        MAX(m.created_at) AS latest_message_time,
                        MAX(m.message) AS latest_message,
                        MAX(m.is_read) AS is_read
                    FROM messages m
                    JOIN users u ON u.id = m.sender_id
                    WHERE m.receiver_id != m.sender_id
                    GROUP BY u.id, u.name, u.image_path, u.role;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS user_conversations_view");
    }
};
