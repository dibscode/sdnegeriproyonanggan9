<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('kelas')) return;

        // ensure the expected column exists before attempting to query/insert
        if (!Schema::hasColumn('kelas', 'nama')) return;

        for ($i = 1; $i <= 6; $i++) {
            $name = (string)$i;
            $exists = DB::table('kelas')->where('nama', $name)->exists();
            if (!$exists) {
                DB::table('kelas')->insert(['nama' => $name, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('kelas')) return;
        DB::table('kelas')->whereIn('nama', ['1','2','3','4','5','6'])->delete();
    }
};
