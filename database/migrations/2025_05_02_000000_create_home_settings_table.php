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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            
            // Featured News Section
            $table->string('featured_title')->default('Trường TH, THCS và THPT Thực hành Sư phạm');
            $table->string('featured_subtitle')->default('Đại học Hạ Long - Nơi ươm mầm tương lai');
            $table->string('featured_image')->default('assets/image/banner_home.jpg');
            
            // Quick Links (JSON array)
            $table->json('quick_links')->nullable();
            
            // Notifications (JSON array)
            $table->json('notifications')->nullable();
            
            // Featured Activities (JSON array)
            $table->json('featured_activities')->nullable();
            
            // Upcoming Events (JSON array)
            $table->json('upcoming_events')->nullable();
            
            // Quick Services (JSON array)
            $table->json('quick_services')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};