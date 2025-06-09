<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // First, convert existing string data to JSON array
            DB::statement('ALTER TABLE tasks ALTER COLUMN category TYPE jsonb USING CASE WHEN category IS NULL THEN NULL ELSE jsonb_build_array(category) END');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Convert JSONB back to string, taking the first element of the array
            DB::statement('ALTER TABLE tasks ALTER COLUMN category TYPE varchar(255) USING CASE WHEN category IS NULL THEN NULL ELSE (category->0)::text END');
        });
    }
};
