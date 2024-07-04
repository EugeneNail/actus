<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('entry_id')->nullable();

            $table->foreign('entry_id')
                ->references('id')
                ->on('entries')
                ->onDelete('set null');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }


    public function down(): void
    {
        Schema::drop('photos');
    }
};
