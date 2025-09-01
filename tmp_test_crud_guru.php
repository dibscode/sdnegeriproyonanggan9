<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

try {
    echo "-- CREATE GURU --\n";
    $username = 'autotest_guru_'.time();
    $user = User::create([
        'name' => 'AutoTest Guru',
        'username' => $username,
        'email' => $username.'@example.test',
        'password' => Hash::make('password'),
        'role' => 'guru',
    ]);
    $guru = Guru::create(['user_id' => $user->id, 'nip' => 'AUTO'.rand(100,999), 'nama' => 'AutoTest Guru']);
    echo "created user.id={$user->id} guru.id={$guru->id}\n";

    echo "-- UPDATE GURU --\n";
    $guru->update(['nama' => 'AutoTest Guru Updated']);
    $guru->refresh();
    echo "updated guru.nama={$guru->nama}\n";

    echo "-- DELETE GURU --\n";
    $gid = $guru->id;
    $guru->delete();
    $exists = Guru::find($gid) ? 'yes' : 'no';
    echo "exists after delete: {$exists}\n";

    // cleanup user
    $user->delete();
    echo "cleanup user done\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
