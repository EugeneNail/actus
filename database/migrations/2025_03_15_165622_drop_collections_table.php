<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('collections');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            CREATE TABLE laravel.collections
            (
                id         BIGINT UNSIGNED AUTO_INCREMENT
                    PRIMARY KEY,
                name       VARCHAR(255)    NOT NULL,
                color      TINYINT         NOT NULL,
                user_id    BIGINT UNSIGNED NOT NULL,
                created_at TIMESTAMP       NULL,
                updated_at TIMESTAMP       NULL,
                CONSTRAINT collections_user_id_foreign
                    FOREIGN KEY (user_id) REFERENCES laravel.users (id)
            )
                COLLATE = utf8mb4_unicode_ci;
        ");
    }
};
