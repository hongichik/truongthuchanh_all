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
            // Thêm các trường bật/tắt hiển thị cho từng section
            $table->boolean('show_featured_banner')->default(true)->after('featured_image');
            $table->boolean('show_quick_links')->default(true)->after('quick_links');
            $table->boolean('show_notifications')->default(true)->after('notifications');
            $table->boolean('show_activities')->default(true)->after('featured_activities');
            $table->boolean('show_events')->default(true)->after('upcoming_events');
            $table->boolean('show_services')->default(true)->after('quick_services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'show_featured_banner',
                'show_quick_links',
                'show_notifications', 
                'show_activities',
                'show_events',
                'show_services'
            ]);
        });
    }
};