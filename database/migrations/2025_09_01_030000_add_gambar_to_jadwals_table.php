<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGambarToJadwalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('jadwals')) {
            return;
        }

        if (!Schema::hasColumn('jadwals', 'gambar')) {
            Schema::table('jadwals', function (Blueprint $table) {
                $table->string('gambar')->nullable()->after('kelas_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('jadwals')) {
            return;
        }

        if (Schema::hasColumn('jadwals', 'gambar')) {
            Schema::table('jadwals', function (Blueprint $table) {
                $table->dropColumn('gambar');
            });
        }
    }
}
