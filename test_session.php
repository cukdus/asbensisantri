<?php

// Test session sederhana
session_start();

echo "=== SESSION TEST ===\n";
echo "Session ID: " . session_id() . "\n";
echo "Session data: " . json_encode($_SESSION ?? [], JSON_PRETTY_PRINT) . "\n";

// Set test session
$_SESSION['test'] = 'test_value';
echo "After setting test: " . json_encode($_SESSION, JSON_PRETTY_PRINT) . "\n";