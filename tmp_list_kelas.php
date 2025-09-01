<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$rows = \DB::select('SELECT id,nama FROM kelas ORDER BY id');
if (empty($rows)) {
	echo "No kelas rows found\n";
} else {
	foreach($rows as $r) echo $r->id . ' ' . $r->nama . "\n";
}
