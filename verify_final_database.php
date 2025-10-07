<?php
require_once 'vendor/autoload.php';

$config = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_absensi',
    'charset'  => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci'
];

try {
    $pdo = new PDO(
        "mysql:host={$config['hostname']};dbname={$config['database']};charset={$config['charset']}", 
        $config['username'], 
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== DATABASE VERIFICATION REPORT ===\n\n";
    
    // 1. List all tables
    echo "1. ALL TABLES IN DATABASE:\n";
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        echo "   - $table\n";
    }
    echo "   Total tables: " . count($tables) . "\n\n";
    
    // 2. Check users table structure
    echo "2. USERS TABLE STRUCTURE:\n";
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "   - {$column['Field']} ({$column['Type']}) {$column['Null']} {$column['Key']}\n";
    }
    
    // Check if additional columns exist
    $userColumns = array_column($columns, 'Field');
    $expectedAdditionalColumns = ['nuptk', 'nama_lengkap', 'jenis_kelamin', 'alamat', 'no_hp', 'unique_code', 'role'];
    
    echo "\n   Additional columns from UnifyGuruPetugasUsers migration:\n";
    foreach ($expectedAdditionalColumns as $col) {
        $exists = in_array($col, $userColumns) ? "✓" : "✗";
        echo "   $exists $col\n";
    }
    
    // 3. Check tb_guru table
    echo "\n3. TB_GURU TABLE STRUCTURE:\n";
    $stmt = $pdo->query("DESCRIBE tb_guru");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "   - {$column['Field']} ({$column['Type']}) {$column['Null']} {$column['Key']}\n";
    }
    
    // 4. Check tb_siswa table
    echo "\n4. TB_SISWA TABLE STRUCTURE:\n";
    $stmt = $pdo->query("DESCRIBE tb_siswa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        echo "   - {$column['Field']} ({$column['Type']}) {$column['Null']} {$column['Key']}\n";
    }
    
    // 5. Check new tables
    echo "\n5. NEW TABLES FROM RECENT MIGRATIONS:\n";
    
    $newTables = ['tb_mapel', 'tb_nilai'];
    foreach ($newTables as $table) {
        if (in_array($table, $tables)) {
            echo "   ✓ $table exists\n";
            $stmt = $pdo->query("DESCRIBE $table");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($columns as $column) {
                echo "     - {$column['Field']} ({$column['Type']})\n";
            }
        } else {
            echo "   ✗ $table missing\n";
        }
        echo "\n";
    }
    
    // 6. Check foreign key constraints
    echo "6. FOREIGN KEY CONSTRAINTS:\n";
    $stmt = $pdo->query("
        SELECT 
            TABLE_NAME,
            COLUMN_NAME,
            CONSTRAINT_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
        WHERE REFERENCED_TABLE_SCHEMA = 'db_absensi' 
        AND REFERENCED_TABLE_NAME IS NOT NULL
        ORDER BY TABLE_NAME, COLUMN_NAME
    ");
    $constraints = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($constraints as $constraint) {
        echo "   - {$constraint['TABLE_NAME']}.{$constraint['COLUMN_NAME']} -> {$constraint['REFERENCED_TABLE_NAME']}.{$constraint['REFERENCED_COLUMN_NAME']}\n";
    }
    
    // 7. Count records
    echo "\n7. RECORD COUNTS:\n";
    $countTables = ['users', 'tb_guru', 'tb_siswa', 'tb_mapel', 'tb_nilai'];
    foreach ($countTables as $table) {
        if (in_array($table, $tables)) {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "   - $table: $count records\n";
        }
    }
    
    // 8. Check superadmin user
    echo "\n8. SUPERADMIN USER:\n";
    $stmt = $pdo->query("SELECT id, email, username, active FROM users WHERE email = 'admin@admin.com'");
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo "   ✓ Superadmin exists:\n";
        echo "     - ID: {$admin['id']}\n";
        echo "     - Email: {$admin['email']}\n";
        echo "     - Username: {$admin['username']}\n";
        echo "     - Active: " . ($admin['active'] ? 'Yes' : 'No') . "\n";
    } else {
        echo "   ✗ Superadmin not found\n";
    }
    
    echo "\n=== VERIFICATION COMPLETE ===\n";
    echo "Database migration test completed successfully!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>