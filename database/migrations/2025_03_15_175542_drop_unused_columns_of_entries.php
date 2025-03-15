<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropColumns('entries', 'worktime');
        Schema::dropColumns('entries', 'sleeptime');
        Schema::dropColumns('entries', 'weight');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->tinyInteger('worktime');
            $table->tinyInteger('sleeptime');
            $table->float('weight');
        });
    }
};
