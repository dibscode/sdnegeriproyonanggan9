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
        if (!Schema::hasTable('kelas')) return;

        Schema::table('kelas', function (Blueprint $table) {
            if (!Schema::hasColumn('kelas', 'nama')) {
                $table->string('nama')->nullable()->after('id');
            }
            if (!Schema::hasColumn('kelas', 'wali_guru_id')) {
                $table->foreignId('wali_guru_id')->nullable()->constrained('gurus')->after('nama');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('kelas')) return;
        Schema::table('kelas', function (Blueprint $table) {
            if (Schema::hasColumn('kelas', 'wali_guru_id')) {
                $table->dropForeign(['wali_guru_id']);
                $table->dropColumn('wali_guru_id');
            }
            if (Schema::hasColumn('kelas', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }
};
