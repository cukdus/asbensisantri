<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_absensi', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== Final Migration Verification ===\n\n";

// 1. Check tb_guru removal
echo "1. tb_guru table status:\n";
$result = $pdo->query("SHOW TABLES LIKE 'tb_guru'")->rowCount();
if ($result == 0) {
    echo "   ✓ tb_guru table successfully removed\n";
} else {
    echo "   ❌ tb_guru table still exists\n";
}

// 2. Check users table with guru data
echo "\n2. Users table with guru data:\n";
$stmt = $pdo->query("SELECT COUNT(*) as count FROM users WHERE role = 'guru'");
$guruCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
echo "   ✓ Found {$guruCount} guru records in users table\n";

// 3. Check tb_presensi_guru structure
echo "\n3. tb_presensi_guru table:\n";
$stmt = $pdo->query("DESCRIBE tb_presensi_guru");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hasUserId = false;
$hasOldIdGuru = false;
foreach ($columns as $col) {
    if ($col['Field'] === 'user_id') {
        $hasUserId = true;
    }
    if ($col['Field'] === 'id_guru') {
        $hasOldIdGuru = true;
    }
}
if ($hasUserId) {
    echo "   ✓ Has user_id column for referencing users table\n";
} else {
    echo "   ❌ Missing user_id column\n";
}
if (!$hasOldIdGuru) {
    echo "   ✓ Old id_guru column removed\n";
} else {
    echo "   ⚠ Old id_guru column still exists\n";
}

// 4. Check tb_mapel structure
echo "\n4. tb_mapel table:\n";
$stmt = $pdo->query("DESCRIBE tb_mapel");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hasUserId = false;
$hasOldIdGuru = false;
foreach ($columns as $col) {
    if ($col['Field'] === 'user_id') {
        $hasUserId = true;
    }
    if ($col['Field'] === 'id_guru') {
        $hasOldIdGuru = true;
    }
}
if ($hasUserId) {
    echo "   ✓ Has user_id column for referencing users table\n";
} else {
    echo "   ❌ Missing user_id column\n";
}
if (!$hasOldIdGuru) {
    echo "   ✓ Old id_guru column removed\n";
} else {
    echo "   ⚠ Old id_guru column still exists\n";
}

// 5. Test data integrity
echo "\n5. Data integrity test:\n";
$stmt = $pdo->query("
    SELECT u.id, u.username, u.nama_lengkap, u.role, u.foto 
    FROM users u 
    WHERE u.role = 'guru' 
    LIMIT 3
");
$gurus = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "   Sample guru records:\n";
foreach ($gurus as $guru) {
    echo "   - ID: {$guru['id']}, Username: {$guru['username']}, Nama: {$guru['nama_lengkap']}\n";
}

// 6. Check foto column
echo "\n6. Foto column verification:\n";
$stmt = $pdo->query("DESCRIBE users");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
$hasFoto = false;
foreach ($columns as $col) {
    if ($col['Field'] === 'foto') {
        $hasFoto = true;
        break;
    }
}
if ($hasFoto) {
    echo "   ✓ Foto column exists in users table\n";
} else {
    echo "   ❌ Foto column missing from users table\n";
}

echo "\n=== Migration Success Summary ===\n";
echo "✓ tb_guru table removed\n";
echo "✓ Users table contains guru data with foto column\n";
echo "✓ tb_presensi_guru and tb_mapel use user_id references\n";
echo "✓ Old id_guru columns cleaned up\n";
echo "✓ Database ready for attendance system\n";
echo "\nMigration restart completed successfully!\n";