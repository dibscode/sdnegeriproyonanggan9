<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Murid;
use Illuminate\Support\Facades\Hash;

try {
    echo "-- CREATE MURID --\n";
    $username = 'autotest_murid_'.time();
    $user = User::create([
        'name' => 'AutoTest Murid',
        'username' => $username,
        'email' => $username.'@example.test',
        'password' => Hash::make('password'),
        'role' => 'murid',
    ]);
    $murid = Murid::create(['user_id' => $user->id, 'nama' => 'AutoTest Murid']);
    echo "created user.id={$user->id} murid.id={$murid->id}\n";

    echo "-- UPDATE MURID --\n";
    $murid->update(['nama' => 'AutoTest Murid Updated']);
    $murid->refresh();
    echo "updated murid.nama={$murid->nama}\n";

    echo "-- DELETE MURID --\n";
    $mid = $murid->id;
    $murid->delete();
    $exists = Murid::find($mid) ? 'yes' : 'no';
    echo "exists after delete: {$exists}\n";

    // cleanup user
    $user->delete();
    echo "cleanup user done\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
