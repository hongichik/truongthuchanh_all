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
            // Thông tin đặc biệt chi tiết
            $table->enum('is_disabled', ['Không', 'Có'])->default('Không')->after('special_info')->comment('Học sinh là người khuyết tật');
            $table->string('achievements', 500)->nullable()->after('is_disabled')->comment('Giải thưởng đạt được');
            $table->string('achievement_rank', 100)->nullable()->after('achievements')->comment('Giải cao nhất đạt được');
            $table->enum('is_policy_family', ['Không', 'Có'])->default('Không')->after('achievement_rank')->comment('Con gia đình chính sách');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            $table->dropColumn([
                'is_disabled',
                'achievements', 
                'achievement_rank',
                'is_policy_family'
            ]);
        });
    }
};
