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
            $table->string('academic_transcript_path')->nullable()->comment('Đường dẫn file học bạ');
            $table->json('additional_documents_paths')->nullable()->comment('Đường dẫn các file bổ sung');
            $table->timestamp('documents_uploaded_at')->nullable()->comment('Thời gian upload tài liệu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop10s', function (Blueprint $table) {
            $table->dropColumn([
                'academic_transcript_path',
                'additional_documents_paths', 
                'documents_uploaded_at'
            ]);
        });
    }
};
