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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')->constrained('murids')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas');
            $table->integer('semester');
            $table->string('tahun_ajaran');
            $table->foreignId('mapel_id')->constrained('mata_pelajarans');
            $table->integer('nilai');
            $table->foreignId('wali_guru_id')->nullable()->constrained('gurus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
