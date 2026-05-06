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
        // First convert values to strings if tinyint was used (but it's a new migration)
        // Since sqlite doesn't support modifying enum easily or if they use mysql, let's just use DB::statement for safety
        DB::statement('ALTER TABLE dang_ky_lop6s MODIFY COLUMN is_disabled ENUM("Không", "Có") NOT NULL DEFAULT "Không"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE dang_ky_lop6s MODIFY COLUMN is_disabled TINYINT(1) NOT NULL DEFAULT 0');
    }
};
