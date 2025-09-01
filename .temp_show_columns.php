<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$cols = Illuminate\Support\Facades\DB::select('SHOW COLUMNS FROM beritas');
print_r($cols);
