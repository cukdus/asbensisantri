<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_absensi', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT waha_api_url, waha_api_key, waha_x_api_key, wa_template_masuk, wa_template_pulang FROM general_settings WHERE id = 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "=== WHATSAPP SETTINGS VERIFICATION ===\n";
    echo "WAHA API URL: " . ($result['waha_api_url'] ?? 'NULL') . "\n";
    echo "WAHA API Key: " . ($result['waha_api_key'] ?? 'NULL') . "\n";
    echo "WAHA X-API-Key: " . ($result['waha_x_api_key'] ?? 'NULL') . "\n";
    echo "Template Masuk: " . ($result['wa_template_masuk'] ?? 'NULL') . "\n";
    echo "Template Pulang: " . ($result['wa_template_pulang'] ?? 'NULL') . "\n";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>