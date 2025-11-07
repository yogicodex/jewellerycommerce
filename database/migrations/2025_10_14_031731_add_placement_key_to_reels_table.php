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
        Schema::table('reels', function (Blueprint $table) {
            // This line adds a new string column named 'placement_key'.
            // It's allowed to be empty (nullable).
            // It must be unique, so two reels can't have the same key.
            // We place it right after the 'title' column for organization.
            $table->string('placement_key')->nullable()->unique()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reels', function (Blueprint $table) {
            // This tells Laravel how to undo the migration: by dropping the column.
            $table->dropColumn('placement_key');
        });
    }
};