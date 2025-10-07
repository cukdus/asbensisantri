<?php
// Test what's actually being returned from the server
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => 'http://localhost/absensi/admin/absen-siswa',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'kelas' => 'Test Kelas',
        'id_kelas' => 14,
        'tanggal' => '2025-10-01'
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/x-www-form-urlencoded'
    ],
    CURLOPT_HEADER => true,
    CURLOPT_FOLLOWLOCATION => true
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "\n";
echo "Error: " . $error . "\n";
echo "Response length: " . strlen($response) . "\n";
echo "First 1000 characters of response:\n";
echo substr($response, 0, 1000) . "\n";

// Check if it's JSON or HTML
if (strpos($response, '{') !== false && strpos($response, '}') !== false) {
    echo "\nResponse appears to be JSON\n";
} else if (strpos($response, '<html') !== false || strpos($response, '<!DOCTYPE') !== false) {
    echo "\nResponse appears to be HTML\n";
    // Look for error indicators
    if (strpos($response, 'error') !== false) {
        echo "HTML contains 'error' keyword\n";
    }
    if (strpos($response, 'Exception') !== false) {
        echo "HTML contains 'Exception' keyword\n";
    }
    if (strpos($response, 'Fatal') !== false) {
        echo "HTML contains 'Fatal' keyword\n";
    }
}