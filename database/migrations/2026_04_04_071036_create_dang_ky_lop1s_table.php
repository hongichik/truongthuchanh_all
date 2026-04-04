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
        Schema::create('dang_ky_lop1s', function (Blueprint $table) {
            $table->id();
            
            // Thông tin cá nhân học sinh
            $table->string('fullname');
            $table->date('birthdate');
            $table->enum('gender', ['Nam', 'Nữ']);
            $table->string('ethnicity')->nullable();
            $table->string('citizen_id')->nullable();
            $table->text('address');
            $table->string('phone', 20);
            
            // Thông tin người giám hộ 
            $table->string('guardian_name');
            $table->string('guardian_phone', 20)->nullable();
            
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
        Schema::dropIfExists('dang_ky_lop1s');
    }
};
