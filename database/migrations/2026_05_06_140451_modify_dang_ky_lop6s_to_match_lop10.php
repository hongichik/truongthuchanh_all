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
        Schema::table('dang_ky_lop6s', function (Blueprint $table) {
            $table->dropColumn(['guardian_name', 'guardian_phone']);
            
            // Thông tin gia đình 
            $table->string('father_name')->nullable()->after('phone');
            $table->string('father_ethnicity')->nullable()->after('father_name');
            $table->string('mother_name')->nullable()->after('father_ethnicity');
            $table->string('mother_ethnicity')->nullable()->after('mother_name');
            
            // Kết quả học tập các lớp
            $table->string('grade1_academic')->nullable()->after('mother_ethnicity');
            $table->string('grade1_conduct')->nullable()->after('grade1_academic');
            $table->string('grade2_academic')->nullable()->after('grade1_conduct');
            $table->string('grade2_conduct')->nullable()->after('grade2_academic');
            $table->string('grade3_academic')->nullable()->after('grade2_conduct');
            $table->string('grade3_conduct')->nullable()->after('grade3_academic');
            $table->string('grade4_academic')->nullable()->after('grade3_conduct');
            $table->string('grade4_conduct')->nullable()->after('grade4_academic');
            $table->string('grade5_academic')->nullable()->after('grade4_conduct');
            $table->string('grade5_conduct')->nullable()->after('grade5_academic');
            
            $table->float('grade5_math_avg', 4, 2)->nullable()->after('grade5_conduct');
            $table->float('grade5_literature_avg', 4, 2)->nullable()->after('grade5_math_avg');
            
            $table->boolean('is_disabled')->default(false)->after('status');
            $table->text('achievements')->nullable()->after('is_disabled');
            $table->string('achievement_rank')->nullable()->after('achievements');
            
            $table->json('academic_transcript_path')->nullable()->after('achievement_rank');
            $table->json('additional_documents_paths')->nullable()->after('academic_transcript_path');
            $table->timestamp('documents_uploaded_at')->nullable()->after('additional_documents_paths');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop6s', function (Blueprint $table) {
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            
            $table->dropColumn([
                'father_name', 'father_ethnicity', 'mother_name', 'mother_ethnicity',
                'grade1_academic', 'grade1_conduct', 'grade2_academic', 'grade2_conduct',
                'grade3_academic', 'grade3_conduct', 'grade4_academic', 'grade4_conduct',
                'grade5_academic', 'grade5_conduct', 'grade5_math_avg', 'grade5_literature_avg',
                'is_disabled', 'achievements', 'achievement_rank',
                'academic_transcript_path', 'additional_documents_paths', 'documents_uploaded_at'
            ]);
        });
    }
};
