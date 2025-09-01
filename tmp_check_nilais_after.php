<?php
$pdo=new PDO('mysql:host=127.0.0.1;dbname=sdfarhannf;charset=utf8','root','');
foreach($pdo->query('SHOW COLUMNS FROM nilais') as $c) echo $c['Field']."\n";
