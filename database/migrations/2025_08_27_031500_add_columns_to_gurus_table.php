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
        Schema::table('gurus', function (Blueprint $table) {
            if (!Schema::hasColumn('gurus', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('gurus', 'nip')) {
                $table->string('nip')->nullable();
            }
            if (!Schema::hasColumn('gurus', 'nama')) {
                $table->string('nama')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gurus', function (Blueprint $table) {
            if (Schema::hasColumn('gurus', 'user_id')) {
                $table->dropForeign([ 'user_id' ]);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('gurus', 'nip')) {
                $table->dropColumn('nip');
            }
            if (Schema::hasColumn('gurus', 'nama')) {
                $table->dropColumn('nama');
            }
        });
    }
};
