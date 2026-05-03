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
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('contacts', 'status')) {
                $table->enum('status', ['pending', 'replied', 'archived'])->default('pending');
            }
            if (!Schema::hasColumn('contacts', 'admin_reply')) {
                $table->text('admin_reply')->nullable();
            }
            if (!Schema::hasColumn('contacts', 'replied_at')) {
                $table->timestamp('replied_at')->nullable();
            }
            if (!Schema::hasColumn('contacts', 'replied_by')) {
                $table->unsignedBigInteger('replied_by')->nullable();
                $table->foreign('replied_by')->references('id')->on('admin')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Drop foreign key first
            if (Schema::hasColumn('contacts', 'replied_by')) {
                $table->dropForeign(['replied_by']);
                $table->dropColumn('replied_by');
            }
            if (Schema::hasColumn('contacts', 'replied_at')) {
                $table->dropColumn('replied_at');
            }
            if (Schema::hasColumn('contacts', 'admin_reply')) {
                $table->dropColumn('admin_reply');
            }
            if (Schema::hasColumn('contacts', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};