<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->string('diary', 10000)->change();
        });
    }


    public function down(): void
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->string('diary', 5000)->change();
        });
    }
};
