<?php

// Bootstrap CodeIgniter
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once __DIR__ . '/vendor/autoload.php';

// Boot the framework
$app = \CodeIgniter\Config\Services::codeigniter();
$app->initialize();

// Load necessary services
$db = \Config\Database::connect();
$userModel = new \App\Models\UserModel();

echo "=== Testing Login Fix After Migration ===\n\n";

// Test 1: Check if superadmin user exists
echo "1. Checking superadmin user...\n";
$superadmin = $userModel->where('username', 'superadmin')->first();

if ($superadmin) {
    echo "   ✓ Superadmin user found:\n";
    echo "     - ID: {$superadmin->id}\n";
    echo "     - Email: {$superadmin->email}\n";
    echo "     - Username: {$superadmin->username}\n";
    echo "     - Is Superadmin: {$superadmin->is_superadmin}\n";
    echo "     - Active: {$superadmin->active}\n";
    echo "     - Password Hash: " . substr($superadmin->password_hash, 0, 20) . "...\n";
} else {
    echo "   ✗ Superadmin user not found!\n";
    exit(1);
}

// Test 2: Test password verification
echo "\n2. Testing password verification...\n";
$testPassword = 'superadmin';

// Test with Myth\Auth\Password::verify
try {
    $mythVerify = \Myth\Auth\Password::verify($testPassword, $superadmin->password_hash);
    echo "   - Myth\\Auth\\Password::verify('superadmin'): " . ($mythVerify ? "✓ SUCCESS" : "✗ FAILED") . "\n";
} catch (Exception $e) {
    echo "   - Myth\\Auth\\Password::verify error: " . $e->getMessage() . "\n";
}

// Test with PHP native password_verify
try {
    $nativeVerify = password_verify($testPassword, $superadmin->password_hash);
    echo "   - password_verify('superadmin'): " . ($nativeVerify ? "✓ SUCCESS" : "✗ FAILED") . "\n";
} catch (Exception $e) {
    echo "   - password_verify error: " . $e->getMessage() . "\n";
}

// Test 3: Test authentication service
echo "\n3. Testing authentication service...\n";
try {
    $auth = \Config\Services::authentication();
    $loginResult = $auth->attempt([
        'login' => 'superadmin',
        'password' => 'superadmin'
    ]);
    
    echo "   - Auth service login attempt: " . ($loginResult ? "✓ SUCCESS" : "✗ FAILED") . "\n";
    
    if (!$loginResult) {
        $errors = $auth->error();
        echo "   - Auth errors: " . $errors . "\n";
    }
} catch (Exception $e) {
    echo "   - Auth service error: " . $e->getMessage() . "\n";
}

// Test 4: Check all users in database
echo "\n4. All users in database:\n";
$allUsers = $userModel->findAll();
foreach ($allUsers as $user) {
    echo "   - ID: {$user->id}, Email: {$user->email}, Username: {$user->username}, Role: " . ($user->role ?? 'N/A') . "\n";
}

echo "\n=== Test Complete ===\n";
echo "You can now test login at: http://localhost/absensi/admin/login\n";
echo "Credentials: username='superadmin', password='superadmin'\n";