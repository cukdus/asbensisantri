<?php

$pdo = new PDO('mysql:host=localhost;dbname=db_absensi', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== Foreign Key Status ===\n\n";

echo "tb_presensi_guru:\n";
$stmt = $pdo->query('SHOW CREATE TABLE tb_presensi_guru');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo $result['Create Table'] . "\n\n";

echo "tb_mapel:\n";
$stmt = $pdo->query('SHOW CREATE TABLE tb_mapel');
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo $result['Create Table'] . "\n";