<?php
// Test with proper session simulation
session_start();

// Simulate being logged in as admin
$_SESSION['logged_in'] = true;
$_SESSION['role'] = 'admin';
$_SESSION['user_id'] = 1;

// Create a test page that makes the AJAX call
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test with Session</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Test Admin Page with Session</h1>
    
    <button onclick="testAdminAjax()">Test Admin AJAX Call</button>
    <button onclick="testDirectCall()">Test Direct Call</button>
    
    <div id="result"></div>

    <script>
        function testAdminAjax() {
            $.ajax({
                url: 'admin/absen-siswa',
                type: 'POST',
                data: {
                    'kelas': 'Test Kelas Iqro\' 1-3',
                    'id_kelas': 14,
                    'tanggal': '2025-10-01'
                },
                success: function(response) {
                    $('#result').html('<h3>Success:</h3><textarea style="width:100%;height:200px;">' + response.substring(0, 1000) + '</textarea>');
                },
                error: function(xhr, status, error) {
                    $('#result').html('<h3>Error:</h3><p>' + error + '</p><p>Status: ' + status + '</p><p>Response: ' + xhr.responseText.substring(0, 500) + '</p>');
                }
            });
        }
        
        function testDirectCall() {
            // Test calling the controller method directly
            $.ajax({
                url: 'test_controller_response.php',
                type: 'POST',
                data: {
                    'kelas': 'Test Kelas Iqro\' 1-3',
                    'id_kelas': 14,
                    'tanggal': '2025-10-01'
                },
                success: function(response) {
                    $('#result').html('<h3>Direct Call Success:</h3><textarea style="width:100%;height:200px;">' + response.substring(0, 1000) + '</textarea>');
                },
                error: function(xhr, status, error) {
                    $('#result').html('<h3>Direct Call Error:</h3><p>' + error + '</p>');
                }
            });
        }
    </script>
</body>
</html>