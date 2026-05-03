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
        Schema::table('home_settings', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('home_settings', 'category_display_config')) {
                $table->json('category_display_config')->nullable()->comment('Cấu hình hiển thị danh mục bài viết');
            }
            if (!Schema::hasColumn('home_settings', 'show_categories')) {
                $table->boolean('show_categories')->default(true)->comment('Hiển thị danh mục ở trang chủ');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'category_display_config',
                'show_categories'
            ]);
        });
    }
};