<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixNilaisTableAddMissingColumns extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('nilais')) {
            return;
        }

        Schema::table('nilais', function (Blueprint $table) {
            if (!Schema::hasColumn('nilais', 'murid_id')) {
                $table->foreignId('murid_id')->nullable()->constrained('murids')->onDelete('cascade')->after('id');
            }
            if (!Schema::hasColumn('nilais', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable()->constrained('kelas')->after('murid_id');
            }
            if (!Schema::hasColumn('nilais', 'semester')) {
                $table->integer('semester')->nullable()->after('kelas_id');
            }
            if (!Schema::hasColumn('nilais', 'tahun_ajaran')) {
                $table->string('tahun_ajaran')->nullable()->after('semester');
            }
            if (!Schema::hasColumn('nilais', 'mapel_id')) {
                $table->foreignId('mapel_id')->nullable()->constrained('mata_pelajarans')->after('tahun_ajaran');
            }
            if (!Schema::hasColumn('nilais', 'nilai')) {
                $table->integer('nilai')->nullable()->after('mapel_id');
            }
            if (!Schema::hasColumn('nilais', 'wali_guru_id')) {
                $table->foreignId('wali_guru_id')->nullable()->constrained('gurus')->after('nilai');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('nilais')) {
            return;
        }

        Schema::table('nilais', function (Blueprint $table) {
            if (Schema::hasColumn('nilais', 'wali_guru_id')) {
                $table->dropForeign(['wali_guru_id']);
                $table->dropColumn('wali_guru_id');
            }
            if (Schema::hasColumn('nilais', 'nilai')) {
                $table->dropColumn('nilai');
            }
            if (Schema::hasColumn('nilais', 'mapel_id')) {
                $table->dropForeign(['mapel_id']);
                $table->dropColumn('mapel_id');
            }
            if (Schema::hasColumn('nilais', 'tahun_ajaran')) {
                $table->dropColumn('tahun_ajaran');
            }
            if (Schema::hasColumn('nilais', 'semester')) {
                $table->dropColumn('semester');
            }
            if (Schema::hasColumn('nilais', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }
            if (Schema::hasColumn('nilais', 'murid_id')) {
                $table->dropForeign(['murid_id']);
                $table->dropColumn('murid_id');
            }
        });
    }
}
