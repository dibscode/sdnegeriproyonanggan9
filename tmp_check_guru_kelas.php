<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
foreach(App\Models\Guru::all() as $g) {
	echo "Guru: {$g->id} - {$g->nama} (user_id={$g->user_id})\n";
	$ks = $g->kelas;
	if ($ks->isEmpty()) { echo "  (no kelas)\n"; continue; }
	foreach ($ks as $k) echo "  Kelas: {$k->id} {$k->nama} wali={$k->wali_guru_id}\n";
}
