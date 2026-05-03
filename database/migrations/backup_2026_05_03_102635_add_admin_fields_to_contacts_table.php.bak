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
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum('status', ['pending', 'replied', 'archived'])->default('pending')->after('message');
            $table->text('admin_reply')->nullable()->after('status');
            $table->timestamp('replied_at')->nullable()->after('admin_reply');
            $table->unsignedBigInteger('replied_by')->nullable()->after('replied_at');
            
            // Foreign key constraint
            $table->foreign('replied_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['replied_by']);
            $table->dropColumn(['status', 'admin_reply', 'replied_at', 'replied_by']);
        });
    }
};