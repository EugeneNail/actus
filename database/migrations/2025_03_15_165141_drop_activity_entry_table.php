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
        Schema::dropIfExists('activity_entry');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            CREATE TABLE laravel.activity_entry
            (
                id          BIGINT UNSIGNED AUTO_INCREMENT
                    PRIMARY KEY,
                activity_id BIGINT UNSIGNED NOT NULL,
                entry_id    BIGINT UNSIGNED NOT NULL,
                CONSTRAINT activity_entry_activity_id_foreign
                    FOREIGN KEY (activity_id) REFERENCES laravel.activities (id)
                        ON DELETE CASCADE,
                CONSTRAINT activity_entry_entry_id_foreign
                    FOREIGN KEY (entry_id) REFERENCES laravel.entries (id)
                        ON DELETE CASCADE
            )
                COLLATE = utf8mb4_unicode_ci;
        ");
    }
};
