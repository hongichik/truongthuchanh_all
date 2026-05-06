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
            $table->dropColumn(['is_policy_family', 'special_info']);
            
            // Đổi enum sang string
            $table->string('grade6_academic')->nullable()->change();
            $table->string('grade6_conduct')->nullable()->change();
            $table->string('grade7_academic')->nullable()->change();
            $table->string('grade7_conduct')->nullable()->change();
            $table->string('grade8_academic')->nullable()->change();
            $table->string('grade8_conduct')->nullable()->change();
            $table->string('grade9_academic')->nullable()->change();
            $table->string('grade9_conduct')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            $table->string('is_policy_family')->nullable();
            $table->text('special_info')->nullable();
        });
    }
};
