<?php
// Test script to check if CSRF is causing AJAX issues
session_start();

// Simulate getting CSRF token (this would normally come from CodeIgniter)
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
if (!isset($_SESSION['csrf_hash'])) {
    $_SESSION['csrf_hash'] = bin2hex(random_bytes(32));
}

$csrf_token_name = 'csrf_test_name';
$csrf_hash = $_SESSION['csrf_hash'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>CSRF AJAX Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>CSRF AJAX Test</h1>
    
    <button onclick="testWithCSRF()">Test with CSRF Token</button>
    <button onclick="testWithoutCSRF()">Test without CSRF Token</button>
    
    <div id="result"></div>

    <script>
        function testWithCSRF() {
            $.ajax({
                url: 'test_controller_response.php', // Our working test
                type: 'POST',
                data: {
                    'kelas': 'Test Kelas',
                    'id_kelas': 14,
                    'tanggal': '2025-10-01',
                    '<?php echo $csrf_token_name; ?>': '<?php echo $csrf_hash; ?>'
                },
                success: function(response) {
                    $('#result').html('<h3>Success with CSRF:</h3>' + response.substring(0, 500) + '...');
                },
                error: function(xhr, status, error) {
                    $('#result').html('<h3>Error with CSRF:</h3>' + error);
                }
            });
        }
        
        function testWithoutCSRF() {
            $.ajax({
                url: 'test_controller_response.php', // Our working test
                type: 'POST',
                data: {
                    'kelas': 'Test Kelas',
                    'id_kelas': 14,
                    'tanggal': '2025-10-01'
                },
                success: function(response) {
                    $('#result').html('<h3>Success without CSRF:</h3>' + response.substring(0, 500) + '...');
                },
                error: function(xhr, status, error) {
                    $('#result').html('<h3>Error without CSRF:</h3>' + error);
                }
            });
        }
    </script>
</body>
</html>