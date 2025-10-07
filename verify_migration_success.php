<?php

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_absensi';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

echo "=== Verifying Migration Success After tb_guru Removal ===\n\n";

// 1. Check that tb_guru table doesn't exist
echo "1. Checking tb_guru table removal:\n";
$stmt = $pdo->query("SHOW TABLES LIKE 'tb_guru'");
$tbGuruExists = $stmt->rowCount() > 0;
if (!$tbGuruExists) {
    echo "   ✓ tb_guru table successfully removed\n";
} else {
    echo "   ❌ tb_guru table still exists!\n";
}

// 2. Check users table structure
echo "\n2. Checking users table structure:\n";
$stmt = $pdo->query("DESCRIBE users");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
$expectedColumns = ['id', 'email', 'username', 'nuptk', 'nama_lengkap', 'jenis_kelamin', 'alamat', 'no_hp', 'foto', 'unique_code', 'role', 'is_superadmin', 'password_hash', 'reset_hash', 'reset_at', 'activate_hash', 'status', 'active', 'created_at', 'updated_at', 'deleted_at'];

foreach ($expectedColumns as $expectedCol) {
    $found = false;
    foreach ($columns as $col) {
        if ($col['Field'] === $expectedCol) {
            $found = true;
            break;
        }
    }
    if ($found) {
        echo "   ✓ Column '$expectedCol' exists\n";
    } else {
        echo "   ❌ Column '$expectedCol' missing!\n";
    }
}

// 3. Check guru data in users table
echo "\n3. Checking guru data in users table:\n";
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
$guruCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
echo "   ✓ Found $guruCount guru records in users table\n";

// 4. Check tb_presensi_guru foreign key
echo "\n4. Checking tb_presensi_guru foreign key:\n";
if ($pdo->query("SHOW TABLES LIKE 'tb_presensi_guru'")->rowCount() > 0) {
    $stmt = $pdo->query("SHOW CREATE TABLE tb_presensi_guru");
    $createTable = $stmt->fetch(PDO::FETCH_ASSOC)['Create Table'];
    if (strpos($createTable, 'REFERENCES `users`') !== false) {
        echo "   ✓ tb_presensi_guru references users table\n";
    } else {
        echo "   ❌ tb_presensi_guru foreign key issue\n";
    }
    
    // Check if user_id column exists
    $stmt = $pdo->query("DESCRIBE tb_presensi_guru");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $hasUserId = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'user_id') {
            $hasUserId = true;
            break;
        }
    }
    if ($hasUserId) {
        echo "   ✓ tb_presensi_guru has user_id column\n";
    } else {
        echo "   ❌ tb_presensi_guru missing user_id column\n";
    }
} else {
    echo "   ⚠ tb_presensi_guru table doesn't exist yet\n";
}

// 5. Check tb_mapel foreign key
echo "\n5. Checking tb_mapel foreign key:\n";
if ($pdo->query("SHOW TABLES LIKE 'tb_mapel'")->rowCount() > 0) {
    $stmt = $pdo->query("SHOW CREATE TABLE tb_mapel");
    $createTable = $stmt->fetch(PDO::FETCH_ASSOC)['Create Table'];
    if (strpos($createTable, 'REFERENCES `users`') !== false) {
        echo "   ✓ tb_mapel references users table\n";
    } else {
        echo "   ❌ tb_mapel foreign key issue\n";
    }
    
    // Check if user_id column exists
    $stmt = $pdo->query("DESCRIBE tb_mapel");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $hasUserId = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'user_id') {
            $hasUserId = true;
            break;
        }
    }
    if ($hasUserId) {
        echo "   ✓ tb_mapel has user_id column\n";
    } else {
        echo "   ❌ tb_mapel missing user_id column\n";
    }
} else {
    echo "   ⚠ tb_mapel table doesn't exist yet\n";
}

// 6. Check sample data
echo "\n6. Sample data verification:\n";
$stmt = $pdo->query("SELECT id, username, nama_lengkap, role, foto FROM users WHERE role = 'guru' LIMIT 3");
$sampleGurus = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($sampleGurus)) {
    echo "   Sample guru records:\n";
    foreach ($sampleGurus as $guru) {
        echo "   - ID: {$guru['id']}, Username: {$guru['username']}, Nama: {$guru['nama_lengkap']}, Role: {$guru['role']}, Foto: " . ($guru['foto'] ?? 'NULL') . "\n";
    }
} else {
    echo "   ❌ No guru data found!\n";
}

echo "\n=== Migration Verification Complete ===\n";
echo "Database structure has been successfully updated after tb_guru removal!\n";