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
            // Header & Logo
            $table->string('header_image')->default('bg_header.jpg')->after('featured_image');
            $table->string('logo')->default('logo.png')->after('header_image');
            
            // Contact Information (JSON)
            $table->json('contact_info')->nullable()->after('logo');
            
            // School Information (JSON)  
            $table->json('school_info')->nullable()->after('contact_info');
            
            // Social Links (JSON)
            $table->json('social_links')->nullable()->after('school_info');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn([
                'header_image',
                'logo', 
                'contact_info',
                'school_info',
                'social_links'
            ]);
        });
    }
};