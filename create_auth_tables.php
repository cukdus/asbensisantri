<?php

// Simple script to create auth tables using raw SQL
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_absensi';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Creating missing Myth\\Auth tables...\n";

    // Check and create auth_logins table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_logins'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_logins` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `ip_address` varchar(255) DEFAULT NULL,
            `email` varchar(255) DEFAULT NULL,
            `user_id` int(11) unsigned DEFAULT NULL,
            `date` datetime NOT NULL,
            `success` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`),
            KEY `email` (`email`),
            KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_logins table\n";
    } else {
        echo "✓ auth_logins table already exists\n";
    }

    // Check and create auth_tokens table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_tokens'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_tokens` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `selector` varchar(255) NOT NULL,
            `hashedValidator` varchar(255) NOT NULL,
            `user_id` int(11) unsigned NOT NULL,
            `expires` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `selector` (`selector`),
            KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_tokens table\n";
    } else {
        echo "✓ auth_tokens table already exists\n";
    }

    // Check and create auth_reset_attempts table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_reset_attempts'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_reset_attempts` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `ip_address` varchar(255) NOT NULL,
            `user_agent` varchar(255) NOT NULL,
            `token` varchar(255) DEFAULT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_reset_attempts table\n";
    } else {
        echo "✓ auth_reset_attempts table already exists\n";
    }

    // Check and create auth_activation_attempts table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_activation_attempts'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_activation_attempts` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `ip_address` varchar(255) NOT NULL,
            `user_agent` varchar(255) NOT NULL,
            `token` varchar(255) DEFAULT NULL,
            `created_at` datetime NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_activation_attempts table\n";
    } else {
        echo "✓ auth_activation_attempts table already exists\n";
    }

    // Check and create auth_groups table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_groups'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_groups` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_groups table\n";
    } else {
        echo "✓ auth_groups table already exists\n";
    }

    // Check and create auth_permissions table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_permissions'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_permissions` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `description` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_permissions table\n";
    } else {
        echo "✓ auth_permissions table already exists\n";
    }

    // Check and create auth_groups_permissions table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_groups_permissions'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_groups_permissions` (
            `group_id` int(11) unsigned NOT NULL DEFAULT '0',
            `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`group_id`,`permission_id`),
            KEY `permission_id` (`permission_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_groups_permissions table\n";
    } else {
        echo "✓ auth_groups_permissions table already exists\n";
    }

    // Check and create auth_groups_users table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_groups_users'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_groups_users` (
            `group_id` int(11) unsigned NOT NULL DEFAULT '0',
            `user_id` int(11) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`group_id`,`user_id`),
            KEY `user_id` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_groups_users table\n";
    } else {
        echo "✓ auth_groups_users table already exists\n";
    }

    // Check and create auth_users_permissions table
    $result = $pdo->query("SHOW TABLES LIKE 'auth_users_permissions'");
    if ($result->rowCount() == 0) {
        $sql = "CREATE TABLE `auth_users_permissions` (
            `user_id` int(11) unsigned NOT NULL DEFAULT '0',
            `permission_id` int(11) unsigned NOT NULL DEFAULT '0',
            PRIMARY KEY (`user_id`,`permission_id`),
            KEY `permission_id` (`permission_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $pdo->exec($sql);
        echo "✓ Created auth_users_permissions table\n";
    } else {
        echo "✓ auth_users_permissions table already exists\n";
    }

    echo "\n✅ All Myth\\Auth tables have been created successfully!\n";
    echo "You can now test the login functionality.\n";

} catch (PDOException $e) {
    echo "❌ Database Error: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}