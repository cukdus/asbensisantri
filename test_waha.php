<?php

// Manually set environment variables for testing
$_ENV['WAHA_API_URL'] = 'https://wasapbro.eqiyu.id';
$_ENV['WHATSAPP_TOKEN'] = '@#Aremania87';

// Helper function for env
if (!function_exists('env')) {
    function env($key, $default = null) {
        return $_ENV[$key] ?? $default;
    }
}

// Helper function for log_message
if (!function_exists('log_message')) {
    function log_message($level, $message) {
        echo "[$level] $message\n";
    }
}

// Include required files
require_once 'app/Libraries/Whatsapp/Whatsapp.php';
require_once 'app/Libraries/Whatsapp/Waha/Waha.php';
require_once 'app/Libraries/Whatsapp/Waha/WahaBulkMessage.php';
require_once 'app/Libraries/Whatsapp/Waha/WahaMessage.php';

use App\Libraries\Whatsapp\Waha\Waha;

// Test WAHA API
$waha = new Waha();

$testMessage = [
    'destination' => '628569000312',  // Ganti dengan nomor test
    'message' => 'Test pesan dari aplikasi absensi',
    'delay' => 0
];

echo "Testing WAHA API...\n";
echo 'Base URL: ' . $_ENV['WAHA_API_URL'] . "\n";
echo 'Token: ' . $_ENV['WHATSAPP_TOKEN'] . "\n";
echo 'Message format: ' . json_encode($testMessage) . "\n\n";

$response = $waha->sendMessage($testMessage);

echo 'Response: ' . $response . "\n";
