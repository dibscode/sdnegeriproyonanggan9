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
        if (! Schema::hasTable('beritas')) {
            return;
        }

        Schema::table('beritas', function (Blueprint $table) {
            // add columns only if they are missing (safe)
            if (! Schema::hasColumn('beritas', 'judul')) {
                $table->string('judul')->nullable()->after('id');
            }

            if (! Schema::hasColumn('beritas', 'isi')) {
                $table->text('isi')->nullable()->after('judul');
            }

            if (! Schema::hasColumn('beritas', 'gambar')) {
                $table->string('gambar')->nullable()->after('isi');
            }

            if (! Schema::hasColumn('beritas', 'penulis_id')) {
                // add as unsignedBigInteger to avoid failing if gurus table FK is not present
                $table->unsignedBigInteger('penulis_id')->nullable()->after('gambar');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('beritas')) {
            return;
        }

        Schema::table('beritas', function (Blueprint $table) {
            if (Schema::hasColumn('beritas', 'penulis_id')) {
                $table->dropColumn('penulis_id');
            }
            if (Schema::hasColumn('beritas', 'gambar')) {
                $table->dropColumn('gambar');
            }
            if (Schema::hasColumn('beritas', 'isi')) {
                $table->dropColumn('isi');
            }
            if (Schema::hasColumn('beritas', 'judul')) {
                $table->dropColumn('judul');
            }
        });
    }
};
