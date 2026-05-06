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
            // Thêm nơi sinh
            $table->string('birthplace')->nullable()->after('address');
            
            // Cha: thêm năm sinh, nghề nghiệp
            $table->integer('father_birthyear')->nullable()->after('father_ethnicity');
            $table->string('father_occupation')->nullable()->after('father_birthyear');
            
            // Mẹ: thêm năm sinh, nghề nghiệp
            $table->integer('mother_birthyear')->nullable()->after('mother_ethnicity');
            $table->string('mother_occupation')->nullable()->after('mother_birthyear');
            
            // Người giám hộ
            $table->string('guardian_name')->nullable()->after('mother_occupation');
            $table->integer('guardian_birthyear')->nullable()->after('guardian_name');
            $table->string('guardian_occupation')->nullable()->after('guardian_birthyear');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            $table->dropColumn([
                'birthplace',
                'father_birthyear',
                'father_occupation',
                'mother_birthyear',
                'mother_occupation',
                'guardian_name',
                'guardian_birthyear',
                'guardian_occupation'
            ]);
        });
    }
};
