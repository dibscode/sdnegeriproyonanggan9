<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$u = App\Models\User::find(4);
if (!$u) { echo "User #4 not found\n"; exit(0); }
echo "User: {$u->id} {$u->name} role={$u->role}\n";
echo "Has guru? ".($u->guru ? 'yes id='.$u->guru->id : 'no')."\n";
echo "Has murid? ".($u->murid ? 'yes id='.$u->murid->id : 'no')."\n";
