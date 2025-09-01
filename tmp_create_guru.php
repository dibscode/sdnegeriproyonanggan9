<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Guru;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

$username = 'test_guru_'.time();
$email = $username.'@example.test';

try {
    $user = User::create([
        'name' => 'Guru Test',
        'username' => $username,
        'email' => $email,
        'password' => Hash::make('password'),
        'role' => 'guru',
    ]);

    $guru = Guru::create([
        'user_id' => $user->id,
        'nip' => 'NIP'.rand(1000,9999),
        'nama' => 'Guru Test',
    ]);

    echo "Created user id: {$user->id}\n";
    echo "Created guru id: {$guru->id}\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
