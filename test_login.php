<?php

require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

// Load necessary services
$auth = \Config\Services::authentication();
$config = config('Auth');

echo "=== TESTING LOGIN PROCESS ===\n\n";

// Test credentials
$username = 'admin';
$password = 'admin123';

echo "Testing login with:\n";
echo "Username: $username\n";
echo "Password: $password\n\n";

try {
    // Test 1: Direct authentication attempt
    echo "=== TEST 1: Direct Authentication ===\n";
    
    $result = $auth->attempt([
        'login' => $username,
        'password' => $password
    ]);
    
    if ($result) {
        echo "✅ Authentication: SUCCESS\n";
        echo "User ID: " . $auth->id() . "\n";
        echo "Username: " . $auth->user()->username . "\n";
    } else {
        echo "❌ Authentication: FAILED\n";
        echo "Error: " . $auth->error() . "\n";
    }
    
    // Test 2: Check user model directly
    echo "\n=== TEST 2: User Model Check ===\n";
    
    $userModel = new \App\Models\UserModel();
    $user = $userModel->where('username', $username)->first();
    
    if ($user) {
        echo "✅ User found in model\n";
        echo "ID: " . $user->id . "\n";
        echo "Username: " . $user->username . "\n";
        echo "Email: " . $user->email . "\n";
        echo "Active: " . ($user->active ? 'Yes' : 'No') . "\n";
        echo "Password Hash: " . $user->password_hash . "\n";
        
        // Test password verification
        if (password_verify($password, $user->password_hash)) {
            echo "✅ Password verification: SUCCESS\n";
        } else {
            echo "❌ Password verification: FAILED\n";
        }
    } else {
        echo "❌ User not found in model\n";
    }
    
    // Test 3: Check validation rules
    echo "\n=== TEST 3: Validation Rules ===\n";
    
    $validation = \Config\Services::validation();
    $validation->setRules([
        'login' => 'required',
        'password' => 'required'
    ]);
    
    $data = [
        'login' => $username,
        'password' => $password
    ];
    
    if ($validation->run($data)) {
        echo "✅ Validation: PASSED\n";
    } else {
        echo "❌ Validation: FAILED\n";
        print_r($validation->getErrors());
    }
    
    // Test 4: Check auth configuration
    echo "\n=== TEST 4: Auth Configuration ===\n";
    echo "Valid Fields: " . implode(', ', $config->validFields) . "\n";
    echo "Allow Registration: " . ($config->allowRegistration ? 'Yes' : 'No') . "\n";
    echo "Require Activation: " . ($config->requireActivation ? 'Yes' : 'No') . "\n";
    echo "Allow Remembering: " . ($config->allowRemembering ? 'Yes' : 'No') . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}