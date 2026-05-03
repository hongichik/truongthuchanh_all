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
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            // Change academic_transcript_path from string to JSON to support multiple files
            $table->json('academic_transcript_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            // Revert back to string
            $table->string('academic_transcript_path')->nullable()->change();
        });
    }
};
