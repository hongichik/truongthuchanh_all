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
            $table->string('birthplace')->nullable()->after('address');
            $table->string('father_name')->nullable()->after('phone');
            $table->string('father_ethnicity')->nullable()->after('father_name');
            $table->integer('father_birthyear')->nullable()->after('father_ethnicity');
            $table->string('father_occupation')->nullable()->after('father_birthyear');
            $table->string('mother_name')->nullable()->after('father_occupation');
            $table->string('mother_ethnicity')->nullable()->after('mother_name');
            $table->integer('mother_birthyear')->nullable()->after('mother_ethnicity');
            $table->string('mother_occupation')->nullable()->after('mother_birthyear');
            $table->integer('guardian_birthyear')->nullable()->after('guardian_name');
            $table->string('guardian_occupation')->nullable()->after('guardian_birthyear');
            $table->string('is_disabled', 500)->nullable()->after('notes');
            $table->text('achievements')->nullable()->after('is_disabled');
            $table->string('achievement_rank')->nullable()->after('achievements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop1s', function (Blueprint $table) {
            $table->dropColumn([
                'birthplace',
                'father_name',
                'father_ethnicity',
                'father_birthyear',
                'father_occupation',
                'mother_name',
                'mother_ethnicity',
                'mother_birthyear',
                'mother_occupation',
                'guardian_birthyear',
                'guardian_occupation',
                'is_disabled',
                'achievements',
                'achievement_rank',
            ]);
        });
    }
};
