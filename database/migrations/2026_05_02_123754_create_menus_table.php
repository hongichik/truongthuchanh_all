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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên menu
            $table->string('slug')->unique(); // Slug của menu
            $table->string('url')->nullable(); // URL liên kết
            $table->string('icon')->nullable(); // Icon của menu
            $table->text('description')->nullable(); // Mô tả
            $table->unsignedBigInteger('parent_id')->nullable(); // Menu cha
            $table->integer('sort_order')->default(0); // Thứ tự sắp xếp
            $table->enum('target', ['_self', '_blank'])->default('_self'); // Loại liên kết
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái
            $table->enum('position', ['header', 'footer', 'sidebar'])->default('header'); // Vị trí hiển thị
            $table->timestamps();
            
            $table->foreign('parent_id')->references('id')->on('menus')->onDelete('cascade');
            $table->index(['parent_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
