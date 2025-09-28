-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 24, 2025 at 08:07 AM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_activation_attempts`
--

DROP TABLE IF EXISTS `auth_activation_attempts`;
CREATE TABLE IF NOT EXISTS `auth_activation_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE IF NOT EXISTS `auth_groups` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_permissions`
--

DROP TABLE IF EXISTS `auth_groups_permissions`;
CREATE TABLE IF NOT EXISTS `auth_groups_permissions` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups_users`
--

DROP TABLE IF EXISTS `auth_groups_users`;
CREATE TABLE IF NOT EXISTS `auth_groups_users` (
  `group_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_logins`
--

DROP TABLE IF EXISTS `auth_logins`;
CREATE TABLE IF NOT EXISTS `auth_logins` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'adminsuper@gmail.com', 1, '2025-09-24 14:03:53', 1),
(2, '::1', 'adminsuper@gmail.com', 1, '2025-09-24 14:24:52', 1),
(3, '::1', 'adminsuper@gmail.com', 1, '2025-09-24 14:55:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `auth_permissions`
--

DROP TABLE IF EXISTS `auth_permissions`;
CREATE TABLE IF NOT EXISTS `auth_permissions` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_reset_attempts`
--

DROP TABLE IF EXISTS `auth_reset_attempts`;
CREATE TABLE IF NOT EXISTS `auth_reset_attempts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_permissions`
--

DROP TABLE IF EXISTS `auth_users_permissions`;
CREATE TABLE IF NOT EXISTS `auth_users_permissions` (
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `permission_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

DROP TABLE IF EXISTS `general_settings`;
CREATE TABLE IF NOT EXISTS `general_settings` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `logo` varchar(225) DEFAULT NULL,
  `school_name` varchar(225) DEFAULT 'SMK 1 Indonesia',
  `school_year` varchar(225) DEFAULT '2024/2025',
  `copyright` varchar(225) DEFAULT '© 2025 All rights reserved.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `logo`, `school_name`, `school_year`, `copyright`) VALUES
(1, 'uploads/logo/logo_68d3a0a32d5fd3-38865000.jpg', 'Pondok Pesantren Sirojan Muniro Assalam', '2024/2025', '© 2025 All rights reserved.');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', 1758696681, 1),
(6, '2023-08-18-000001', 'App\\Database\\Migrations\\CreateJurusanTable', 'default', 'App', 1758697242, 2),
(7, '2023-08-18-000002', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1758697242, 2),
(8, '2023-08-18-000003', 'App\\Database\\Migrations\\CreateDB', 'default', 'App', 1758697393, 3),
(9, '2023-08-18-000004', 'App\\Database\\Migrations\\AddSuperadmin', 'default', 'App', 1758697393, 3),
(10, '2024-07-24-083011', 'App\\Database\\Migrations\\GeneralSettings', 'default', 'App', 1758697393, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_guru`
--

DROP TABLE IF EXISTS `tb_guru`;
CREATE TABLE IF NOT EXISTS `tb_guru` (
  `id_guru` int(11) NOT NULL AUTO_INCREMENT,
  `nuptk` varchar(24) NOT NULL,
  `nama_guru` varchar(255) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `unique_code` varchar(64) NOT NULL,
  PRIMARY KEY (`id_guru`),
  UNIQUE KEY `unique_code` (`unique_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jurusan`
--

DROP TABLE IF EXISTS `tb_jurusan`;
CREATE TABLE IF NOT EXISTS `tb_jurusan` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `jurusan` varchar(32) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `jurusan` (`jurusan`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'OTKP', '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(2, 'BDP', '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(3, 'AKL', '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(4, 'RPL', '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kehadiran`
--

DROP TABLE IF EXISTS `tb_kehadiran`;
CREATE TABLE IF NOT EXISTS `tb_kehadiran` (
  `id_kehadiran` int(11) NOT NULL AUTO_INCREMENT,
  `kehadiran` enum('Hadir','Sakit','Izin','Tanpa keterangan') NOT NULL,
  PRIMARY KEY (`id_kehadiran`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `tb_kehadiran`
--

INSERT INTO `tb_kehadiran` (`id_kehadiran`, `kehadiran`) VALUES
(1, 'Hadir'),
(2, 'Sakit'),
(3, 'Izin'),
(4, 'Tanpa keterangan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

DROP TABLE IF EXISTS `tb_kelas`;
CREATE TABLE IF NOT EXISTS `tb_kelas` (
  `id_kelas` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kelas` varchar(32) NOT NULL,
  `id_jurusan` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `tb_kelas_id_jurusan_foreign` (`id_jurusan`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `kelas`, `id_jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'X', 1, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(2, 'X', 2, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(3, 'X', 3, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(4, 'X', 4, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(5, 'XI', 1, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(6, 'XI', 2, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(7, 'XI', 3, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(8, 'XI', 4, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(9, 'XII', 1, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(10, 'XII', 2, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(11, 'XII', 3, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL),
(12, 'XII', 4, '2025-09-24 07:00:42', '2025-09-24 07:00:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi_guru`
--

DROP TABLE IF EXISTS `tb_presensi_guru`;
CREATE TABLE IF NOT EXISTS `tb_presensi_guru` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_guru` int(11) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_presensi`),
  KEY `id_kehadiran` (`id_kehadiran`),
  KEY `id_guru` (`id_guru`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi_siswa`
--

DROP TABLE IF EXISTS `tb_presensi_siswa`;
CREATE TABLE IF NOT EXISTS `tb_presensi_siswa` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `id_kelas` int(11) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  PRIMARY KEY (`id_presensi`),
  KEY `id_siswa` (`id_siswa`),
  KEY `id_kehadiran` (`id_kehadiran`),
  KEY `id_kelas` (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `tb_presensi_siswa`
--

INSERT INTO `tb_presensi_siswa` (`id_presensi`, `id_siswa`, `id_kelas`, `tanggal`, `jam_masuk`, `jam_keluar`, `id_kehadiran`, `keterangan`) VALUES
(6, 2, 1, '2025-09-24', '15:05:53', NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

DROP TABLE IF EXISTS `tb_siswa`;
CREATE TABLE IF NOT EXISTS `tb_siswa` (
  `id_siswa` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(16) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `id_kelas` int(11) UNSIGNED NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_hp` varchar(32) NOT NULL,
  `unique_code` varchar(64) NOT NULL,
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `unique_code` (`unique_code`),
  KEY `id_kelas` (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `nis`, `nama_siswa`, `id_kelas`, `jenis_kelamin`, `no_hp`, `unique_code`) VALUES
(2, 'SMA250100001', 'kuchink cukdus', 1, 'Laki-laki', '08569000312', '68d3a43e8a1de9-61808703-55178903');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `is_superadmin` tinyint(1) NOT NULL DEFAULT 0,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `is_superadmin`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'adminsuper@gmail.com', 'superadmin', 1, '$2y$10$CAB4gZLBg/9NprZVXIzB9umOp9MkO6MQ/DGUYfJBykdgJtjHqlCUG', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2025-09-24 14:55:51', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_presensi_guru`
--
ALTER TABLE `tb_presensi_guru`
  ADD CONSTRAINT `tb_presensi_guru_ibfk_2` FOREIGN KEY (`id_kehadiran`) REFERENCES `tb_kehadiran` (`id_kehadiran`),
  ADD CONSTRAINT `tb_presensi_guru_ibfk_3` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
