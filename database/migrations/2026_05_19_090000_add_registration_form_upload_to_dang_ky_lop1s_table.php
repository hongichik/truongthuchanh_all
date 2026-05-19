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
        Schema::table('dang_ky_lop1s', function (Blueprint $table) {
            $table->string('registration_form_path')->nullable()->after('achievement_rank');
            $table->timestamp('registration_form_uploaded_at')->nullable()->after('registration_form_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop1s', function (Blueprint $table) {
            $table->dropColumn([
                'registration_form_path',
                'registration_form_uploaded_at',
            ]);
        });
    }
};
