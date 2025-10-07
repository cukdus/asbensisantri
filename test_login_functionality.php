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

echo "=== Testing Login Functionality ===\n\n";

// Test 1: Check if admin users exist
echo "1. Checking admin users...\n";
$adminUsers = $userModel->whereIn('email', ['admin@admin.com', 'adminsuper@gmail.com'])->findAll();
foreach ($adminUsers as $user) {
    echo "   - Found user: {$user->email} (username: {$user->username})\n";
}

// Test 2: Check auth_logins table structure
echo "\n2. Checking auth_logins table structure...\n";
$fields = $db->getFieldData('auth_logins');
$hasLoginField = false;
foreach ($fields as $field) {
    echo "   - Field: {$field->name} ({$field->type})\n";
    if ($field->name === 'login') {
        $hasLoginField = true;
    }
}

if ($hasLoginField) {
    echo "   ✓ 'login' field exists in auth_logins table\n";
} else {
    echo "   ✗ 'login' field missing in auth_logins table\n";
}

// Test 3: Test recordLoginAttempt method
echo "\n3. Testing recordLoginAttempt method...\n";
try {
    // Test with username
    $result1 = $userModel->recordLoginAttempt('admin', true, 1);
    echo "   ✓ Login attempt recorded with username 'admin'\n";
    
    // Test with email
    $result2 = $userModel->recordLoginAttempt('admin@admin.com', true, 1);
    echo "   ✓ Login attempt recorded with email 'admin@admin.com'\n";
    
} catch (Exception $e) {
    echo "   ✗ Error recording login attempt: " . $e->getMessage() . "\n";
}

// Test 4: Check recorded login attempts
echo "\n4. Checking recorded login attempts...\n";
$loginAttempts = $db->table('auth_logins')->orderBy('id', 'DESC')->limit(5)->get()->getResultArray();
foreach ($loginAttempts as $attempt) {
    echo "   - ID: {$attempt['id']}, Email: {$attempt['email']}, Login: {$attempt['login']}, Success: {$attempt['success']}\n";
}

// Test 5: Check Auth config
echo "\n5. Checking Auth configuration...\n";
$authConfig = new \Config\Auth();
if (isset($authConfig->validFields)) {
    echo "   - validFields: " . implode(', ', $authConfig->validFields) . "\n";
    if (in_array('username', $authConfig->validFields) && in_array('email', $authConfig->validFields)) {
        echo "   ✓ Both email and username are allowed for login\n";
    } else {
        echo "   ✗ Configuration issue: both email and username should be allowed\n";
    }
} else {
    echo "   - validFields not explicitly set (using default)\n";
}

echo "\n=== Test Complete ===\n";
echo "You can now test login at: http://localhost:8080/admin/login\n";
echo "Test credentials:\n";
echo "- Username: admin, Password: admin123\n";
echo "- Username: adminsuper, Password: admin123\n";
echo "- Email: admin@admin.com, Password: admin123\n";
echo "- Email: adminsuper@gmail.com, Password: admin123\n";