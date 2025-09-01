<?php
$pdo=new PDO('mysql:host=127.0.0.1;dbname=sdfarhannf;charset=utf8','root','');
$stmt=$pdo->query('SHOW COLUMNS FROM nilais');
$cols=$stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($cols as $c) echo $c['Field']."\t".$c['Type']."\n";
