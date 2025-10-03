<?php
require_once 'vendor/autoload.php';

$config = [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'db_absensi',
    'charset'  => 'utf8mb4',
    'collation' => 'utf8mb4_general_ci'
];

try {
    $pdo = new PDO(
        "mysql:host={$config['hostname']};dbname={$config['database']};charset={$config['charset']}", 
        $config['username'], 
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to database successfully.\n";
    
    // Create users table manually based on Myth\Auth structure
    $sql = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `username` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `reset_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `reset_at` datetime DEFAULT NULL,
        `reset_expires` datetime DEFAULT NULL,
        `activate_hash` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `status_message` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `active` tinyint(1) NOT NULL DEFAULT 0,
        `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        `deleted_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`),
        UNIQUE KEY `username` (`username`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'users' created successfully.\n";
    
    // Create auth_groups table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_groups` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_groups' created successfully.\n";
    
    // Create auth_permissions table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_permissions` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_permissions' created successfully.\n";
    
    // Create auth_groups_permissions table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_groups_permissions` (
        `group_id` int(11) unsigned NOT NULL DEFAULT 0,
        `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
        KEY `auth_groups_permissions_group_id_foreign` (`group_id`),
        KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
        CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
        CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_groups_permissions' created successfully.\n";
    
    // Create auth_users_permissions table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_users_permissions` (
        `user_id` int(11) unsigned NOT NULL DEFAULT 0,
        `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
        KEY `auth_users_permissions_user_id_foreign` (`user_id`),
        KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
        CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
        CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_users_permissions' created successfully.\n";
    
    // Create auth_groups_users table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_groups_users` (
        `group_id` int(11) unsigned NOT NULL DEFAULT 0,
        `user_id` int(11) unsigned NOT NULL DEFAULT 0,
        KEY `auth_groups_users_group_id_foreign` (`group_id`),
        KEY `auth_groups_users_user_id_foreign` (`user_id`),
        CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
        CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_groups_users' created successfully.\n";
    
    // Create auth_logins table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_logins` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `ip_address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `user_id` int(11) unsigned DEFAULT NULL,
        `date` datetime NOT NULL,
        `success` tinyint(1) NOT NULL,
        PRIMARY KEY (`id`),
        KEY `email` (`email`),
        KEY `user_id` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_logins' created successfully.\n";
    
    // Create auth_tokens table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_tokens` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `selector` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `hashedValidator` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `user_id` int(11) unsigned NOT NULL,
        `expires` datetime NOT NULL,
        PRIMARY KEY (`id`),
        KEY `auth_tokens_user_id_foreign` (`user_id`),
        KEY `selector` (`selector`),
        CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_tokens' created successfully.\n";
    
    // Create auth_reset_attempts table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_reset_attempts` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `user_agent` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_reset_attempts' created successfully.\n";
    
    // Create auth_activation_attempts table
    $sql = "CREATE TABLE IF NOT EXISTS `auth_activation_attempts` (
        `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `ip_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `user_agent` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
        `token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
    
    $pdo->exec($sql);
    echo "Table 'auth_activation_attempts' created successfully.\n";
    
    echo "All Myth\\Auth tables created successfully!\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>