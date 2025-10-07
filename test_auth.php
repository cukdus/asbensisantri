<?php

require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$app = require_once 'app/Config/Paths.php';
$app = new $app();

// Load framework
require_once SYSTEMPATH . 'bootstrap.php';

// Load CodeIgniter
$codeigniter = new \CodeIgniter\CodeIgniter($app);
$codeigniter->initialize();

// Test session and auth
$session = \Config\Services::session();

// Check if user is logged in
echo "=== AUTHENTICATION TEST ===\n";
echo "Session ID: " . session_id() . "\n";
echo "logged_in() result: " . (logged_in() ? 'YES' : 'NO') . "\n";

if (logged_in()) {
    $user = user();
    echo "User data: " . json_encode($user, JSON_PRETTY_PRINT) . "\n";
    echo "User role: " . ($user->role ?? 'no role') . "\n";
} else {
    echo "No user logged in\n";
}

echo "\n=== SESSION DATA ===\n";
echo "Session data: " . json_encode($_SESSION ?? [], JSON_PRETTY_PRINT) . "\n";