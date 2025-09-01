<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Guru;

$gurus = \DB::select('SELECT g.id as guru_id, g.user_id, g.nip, g.nama as guru_nama, u.id as user_id, u.name as user_name, u.username, u.email, u.role FROM gurus g LEFT JOIN users u ON g.user_id = u.id ORDER BY g.id');
if (empty($gurus)) {
    echo "No rows in gurus table\n";
} else {
    foreach ($gurus as $r) {
        echo "guru_id:" . ($r->guru_id ?? 'NULL') . " | user_id:" . ($r->user_id ?? 'NULL') . " | username:" . ($r->username ?? 'NULL') . " | email:" . ($r->email ?? 'NULL') . " | nama_guru:" . ($r->guru_nama ?? 'NULL') . "\n";
    }
}

$missing = \DB::select("SELECT id, name, username, email FROM users WHERE role='guru' AND id NOT IN (SELECT user_id FROM gurus WHERE user_id IS NOT NULL)");
if (empty($missing)) {
    echo "\nNo users with role=guru missing in gurus table\n";
} else {
    echo "\nUsers with role=guru missing in gurus table:\n";
    foreach ($missing as $u) {
        echo "user id:" . $u->id . " | username:" . $u->username . " | email:" . $u->email . " | name:" . $u->name . "\n";
    }
}
