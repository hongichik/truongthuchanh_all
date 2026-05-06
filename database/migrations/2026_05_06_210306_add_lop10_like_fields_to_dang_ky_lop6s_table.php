<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dang_ky_lop6s', function (Blueprint $table) {
            $table->string('birthplace')->nullable()->after('address');
            $table->integer('father_birthyear')->nullable()->after('father_ethnicity');
            $table->string('father_occupation')->nullable()->after('father_birthyear');
            $table->integer('mother_birthyear')->nullable()->after('mother_ethnicity');
            $table->string('mother_occupation')->nullable()->after('mother_birthyear');
            $table->string('guardian_name')->nullable()->after('mother_occupation');
            $table->integer('guardian_birthyear')->nullable()->after('guardian_name');
            $table->string('guardian_occupation')->nullable()->after('guardian_birthyear');
        });

        DB::statement('ALTER TABLE dang_ky_lop6s MODIFY COLUMN is_disabled VARCHAR(500) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_lop6s', function (Blueprint $table) {
            $table->dropColumn([
                'birthplace',
                'father_birthyear',
                'father_occupation',
                'mother_birthyear',
                'mother_occupation',
                'guardian_name',
                'guardian_birthyear',
                'guardian_occupation',
            ]);
        });

        DB::statement('ALTER TABLE dang_ky_lop6s MODIFY COLUMN is_disabled ENUM("Không", "Có") NOT NULL DEFAULT "Không"');
    }
};
