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
            // Thêm điểm trung bình Toán và Văn lớp 9
            $table->decimal('grade9_math_avg', 3, 1)->nullable()->after('grade9_conduct')->comment('Điểm trung bình Toán lớp 9');
            $table->decimal('grade9_literature_avg', 3, 1)->nullable()->after('grade9_math_avg')->comment('Điểm trung bình Văn lớp 9');
            
            // Thêm thông tin đặc biệt
            $table->text('special_info')->nullable()->after('notes')->comment('Thông tin đặc biệt khác');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            $table->dropColumn([
                'grade9_math_avg',
                'grade9_literature_avg', 
                'special_info'
            ]);
        });
    }
};
