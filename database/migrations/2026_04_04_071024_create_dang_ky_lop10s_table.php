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
        Schema::create('dang_ky_lop10s', function (Blueprint $table) {
            $table->id();
            
            // Thông tin cá nhân học sinh
            $table->string('fullname');
            $table->date('birthdate');
            $table->enum('gender', ['Nam', 'Nữ']);
            $table->string('ethnicity')->nullable();
            $table->string('current_school');
            $table->string('citizen_id')->nullable();
            $table->text('address');
            $table->string('phone', 20);
            
            // Thông tin gia đình 
            $table->string('father_name')->nullable();
            $table->string('father_ethnicity')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_ethnicity')->nullable();
            
            // Kết quả học tập các lớp
            $table->enum('grade6_academic', ['Xuất sắc', 'Giỏi', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            $table->enum('grade6_conduct', ['Tốt', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            
            $table->enum('grade7_academic', ['Xuất sắc', 'Giỏi', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            $table->enum('grade7_conduct', ['Tốt', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            
            $table->enum('grade8_academic', ['Xuất sắc', 'Giỏi', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            $table->enum('grade8_conduct', ['Tốt', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            
            $table->enum('grade9_academic', ['Xuất sắc', 'Giỏi', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            $table->enum('grade9_conduct', ['Tốt', 'Khá', 'Trung bình', 'Yếu'])->nullable();
            
            // Thông tin trạng thái
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dang_ky_lop10s');
    }
};
