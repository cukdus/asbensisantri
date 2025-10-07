<?php

// Simple database configuration
$dbConfig = [
    'hostname' => 'localhost',
    'database' => 'db_absensi',
    'username' => 'root',
    'password' => '',
    'port' => 3306
];

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['hostname']};dbname={$dbConfig['database']};port={$dbConfig['port']}",
        $dbConfig['username'],
        $dbConfig['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "Connected to database successfully.\n";

    // Get all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Found tables: " . implode(', ', $tables) . "\n";

    // Drop all tables except migrations
    foreach ($tables as $table) {
        if ($table !== 'migrations') {
            echo "Dropping table: $table\n";
            $pdo->exec("DROP TABLE IF EXISTS `$table`");
        }
    }

    // Clear migrations table
    echo "Clearing migrations table...\n";
    $pdo->exec("DELETE FROM migrations");

    echo "Database cleaned successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}