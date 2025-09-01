<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // make alamat TEXT NULLABLE and add tgl_lahir if missing
        if (Schema::hasTable('murids')) {
            // modify alamat to TEXT NULL
            DB::statement("ALTER TABLE `murids` MODIFY COLUMN `alamat` TEXT NULL");

            // add tgl_lahir if not exists
            if (!Schema::hasColumn('murids', 'tgl_lahir')) {
                Schema::table('murids', function (Blueprint $table) {
                    $table->date('tgl_lahir')->nullable()->after('nama');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('murids')) {
            // revert alamat to varchar(255) NOT NULL
            DB::statement("ALTER TABLE `murids` MODIFY COLUMN `alamat` VARCHAR(255) NOT NULL");

            if (Schema::hasColumn('murids', 'tgl_lahir')) {
                Schema::table('murids', function (Blueprint $table) {
                    $table->dropColumn('tgl_lahir');
                });
            }
        }
    }
};
