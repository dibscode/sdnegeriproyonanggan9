<?php
$dsn = "mysql:host=127.0.0.1;dbname=sdfarhannf;charset=utf8";
$user = 'root';
$pass = '';
try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);

    $colsStmt = $pdo->query("SHOW COLUMNS FROM `jadwals`");
    $cols = $colsStmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (!in_array('kelas_id', $cols)) {
        echo "Adding column kelas_id...\n";
        $pdo->exec("ALTER TABLE `jadwals` ADD COLUMN `kelas_id` BIGINT UNSIGNED NULL AFTER `id`");
        echo "Column added.\n";
    } else {
        echo "Column kelas_id already exists.\n";
    }

    // Check for foreign key
    $fkStmt = $pdo->prepare("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'jadwals' AND COLUMN_NAME = 'kelas_id' AND REFERENCED_TABLE_NAME = 'kelas'");
    $fkStmt->execute();
    $fk = $fkStmt->fetch(PDO::FETCH_COLUMN);

    if (!$fk) {
        echo "Adding foreign key constraint...\n";
        // Choose a constraint name unlikely to collide
        $constraintName = 'jadwals_kelas_id_foreign';
        $pdo->exec("ALTER TABLE `jadwals` ADD CONSTRAINT `".$constraintName."` FOREIGN KEY (`kelas_id`) REFERENCES `kelas`(`id`) ON DELETE CASCADE");
        echo "Foreign key added.\n";
    } else {
        echo "Foreign key already exists: $fk\n";
    }

    echo "Done.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
