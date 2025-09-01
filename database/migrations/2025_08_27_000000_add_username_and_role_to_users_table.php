<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->unique()->after('name');
            });

            // populate username from email or name for existing users
            $users = DB::table('users')->get();
            foreach ($users as $u) {
                $username = null;
                if (!empty($u->email)) {
                    $username = Str::before($u->email, '@');
                }
                if (empty($username) && !empty($u->name)) {
                    $username = Str::slug($u->name);
                }
                if (empty($username)) {
                    $username = 'user'.$u->id;
                }
                // ensure uniqueness
                $base = $username;
                $i = 1;
                while (DB::table('users')->where('username', $username)->where('id', '!=', $u->id)->exists()) {
                    $username = $base.$i;
                    $i++;
                }
                DB::table('users')->where('id', $u->id)->update(['username' => $username]);
            }
        }

        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin','guru','murid'])->default('murid')->after('password');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['username']);
                $table->dropColumn('username');
            });
        }
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }
};
