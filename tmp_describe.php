<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$cols = \DB::select('DESCRIBE kelas');
foreach($cols as $c) {
    echo $c->Field . "\t" . $c->Type . "\t" . $c->Null . "\n";
}
