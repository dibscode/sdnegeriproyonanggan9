<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('kelas')) return;
        if (!Schema::hasColumn('kelas', 'nama')) return;

        $sections = ['A','B'];
        for ($grade = 1; $grade <= 6; $grade++) {
            foreach ($sections as $s) {
                $label = $grade . ' ' . $s;
                $exists = DB::table('kelas')->where('nama', $label)->exists();
                if (!$exists) {
                    DB::table('kelas')->insert(['nama' => $label, 'created_at' => now(), 'updated_at' => now()]);
                }
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('kelas')) return;
        $labels = [];
        foreach (range(1,6) as $g) {
            foreach (['A','B'] as $s) $labels[] = $g . ' ' . $s;
        }
        DB::table('kelas')->whereIn('nama', $labels)->delete();
    }
};
