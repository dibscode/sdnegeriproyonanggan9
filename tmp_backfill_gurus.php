<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Guru;

$missing = \DB::select("SELECT id, name, username, email FROM users WHERE role='guru' AND id NOT IN (SELECT user_id FROM gurus WHERE user_id IS NOT NULL)");
if (empty($missing)) {
    echo "No missing users. Nothing to do.\n";
    exit;
}

foreach ($missing as $u) {
    try {
        $g = Guru::create([
            'user_id' => $u->id,
            'nip' => null,
            'nama' => $u->name ?? $u->username,
        ]);
        echo "Created guru row id={$g->id} for user_id={$u->id}\n";
    } catch (Exception $e) {
        echo "Failed for user_id={$u->id}: " . $e->getMessage() . "\n";
    }
}
