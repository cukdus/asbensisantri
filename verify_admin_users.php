<?php

// Bootstrap CodeIgniter
require_once 'app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

// Get database connection
$db = \Config\Database::connect();

echo "=== Verifying Admin Users ===\n\n";

// Check admin user
$adminUser = $db->table('users')->where('email', 'admin@admin.com')->get()->getRowArray();
if ($adminUser) {
    echo "✓ Admin user found:\n";
    echo "  ID: " . $adminUser['id'] . "\n";
    echo "  Email: " . $adminUser['email'] . "\n";
    echo "  Username: " . $adminUser['username'] . "\n";
    echo "  Active: " . ($adminUser['active'] ? 'Yes' : 'No') . "\n";
    echo "  Is Superadmin: " . ($adminUser['is_superadmin'] ? 'Yes' : 'No') . "\n";
    
    // Test password
    $passwordTest = password_verify('admin123', $adminUser['password_hash']);
    echo "  Password 'admin123' verification: " . ($passwordTest ? '✓ PASS' : '✗ FAIL') . "\n";
} else {
    echo "✗ Admin user NOT found!\n";
}

echo "\n";

// Check superadmin user
$superAdminUser = $db->table('users')->where('email', 'adminsuper@gmail.com')->get()->getRowArray();
if ($superAdminUser) {
    echo "✓ Superadmin user found:\n";
    echo "  ID: " . $superAdminUser['id'] . "\n";
    echo "  Email: " . $superAdminUser['email'] . "\n";
    echo "  Username: " . $superAdminUser['username'] . "\n";
    echo "  Active: " . ($superAdminUser['active'] ? 'Yes' : 'No') . "\n";
    echo "  Is Superadmin: " . ($superAdminUser['is_superadmin'] ? 'Yes' : 'No') . "\n";
    
    // Test password
    $passwordTest = password_verify('superadmin', $superAdminUser['password_hash']);
    echo "  Password 'superadmin' verification: " . ($passwordTest ? '✓ PASS' : '✗ FAIL') . "\n";
} else {
    echo "✗ Superadmin user NOT found!\n";
}

echo "\n=== Verifying Other Tables ===\n\n";

// Check jurusan data
$jurusanCount = $db->table('tb_jurusan')->countAllResults();
echo "✓ Jurusan records: $jurusanCount\n";

$jurusanData = $db->table('tb_jurusan')->get()->getResultArray();
foreach ($jurusanData as $jurusan) {
    echo "  - " . $jurusan['jurusan'] . "\n";
}

echo "\n";

// Check kelas data
$kelasCount = $db->table('tb_kelas')->countAllResults();
echo "✓ Kelas records: $kelasCount\n";

// Check kehadiran data
$kehadiranCount = $db->table('tb_kehadiran')->countAllResults();
echo "✓ Kehadiran records: $kehadiranCount\n";

// Check if tb_siswa has unique_code field
$fields = $db->getFieldData('tb_siswa');
$hasUniqueCode = false;
foreach ($fields as $field) {
    if ($field->name === 'unique_code') {
        $hasUniqueCode = true;
        break;
    }
}
echo "✓ tb_siswa has unique_code field: " . ($hasUniqueCode ? 'Yes' : 'No') . "\n";

echo "\n=== Verification Complete ===\n";