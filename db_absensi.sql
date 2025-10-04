-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 03, 2025 at 04:26 AM
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  KEY `email` (`email`(250)),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth_logins`
--

INSERT INTO `auth_logins` (`id`, `ip_address`, `email`, `user_id`, `date`, `success`) VALUES
(1, '::1', 'adminsuper@gmail.com', 1, '2025-10-03 11:18:57', 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  KEY `selector` (`selector`(250))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `waha_api_url` varchar(255) DEFAULT 'http://localhost:3000' COMMENT 'WAHA API URL/Link',
  `waha_api_key` varchar(255) DEFAULT NULL COMMENT 'WAHA API Key (if required)',
  `waha_x_api_key` varchar(255) DEFAULT NULL COMMENT 'WAHA X-API-Key header',
  `wa_template_masuk` text DEFAULT 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.' COMMENT 'Template pesan WhatsApp untuk absen masuk',
  `wa_template_pulang` text DEFAULT 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.' COMMENT 'Template pesan WhatsApp untuk absen pulang',
  `wa_template_guru_masuk` text DEFAULT NULL COMMENT 'Template WhatsApp untuk guru absen masuk',
  `wa_template_guru_pulang` text DEFAULT NULL COMMENT 'Template WhatsApp untuk guru absen pulang',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `logo`, `school_name`, `school_year`, `copyright`, `waha_api_url`, `waha_api_key`, `waha_x_api_key`, `wa_template_masuk`, `wa_template_pulang`, `wa_template_guru_masuk`, `wa_template_guru_pulang`) VALUES
(1, NULL, 'SMK 1 Indonesia', '2024/2025', '© 2025 All rights reserved.', 'http://localhost:3000', NULL, NULL, 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.', 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.', NULL, NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2023-08-18-000001', 'App\\Database\\Migrations\\CreateJurusanTable', 'default', 'App', 1759465105, 1),
(2, '2023-08-18-000002', 'App\\Database\\Migrations\\CreateKelasTable', 'default', 'App', 1759465105, 1),
(3, '2023-08-18-000003', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1759465105, 1),
(4, '2023-08-18-000004', 'App\\Database\\Migrations\\CreateDB', 'default', 'App', 1759465105, 1),
(5, '2023-08-18-000005', 'App\\Database\\Migrations\\AddSuperadmin', 'default', 'App', 1759465105, 1),
(6, '2024-07-24-083011', 'App\\Database\\Migrations\\GeneralSettings', 'default', 'App', 1759465105, 1),
(7, '2025-01-27-120000', 'App\\Database\\Migrations\\AddStudentAdditionalFields', 'default', 'App', 1759465105, 1),
(8, '2025-01-27-130000', 'App\\Database\\Migrations\\UnifyGuruPetugasUsers', 'default', 'App', 1759465105, 1),
(9, '2025-01-27-150000', 'App\\Database\\Migrations\\AddFotoToUsers', 'default', 'App', 1759465105, 1),
(10, '2025-01-28-000000', 'App\\Database\\Migrations\\RemoveDeletedAtFromUsers', 'default', 'App', 1759465105, 1),
(11, '2025-09-27-100714', 'App\\Database\\Migrations\\AddPhotoToSiswa', 'default', 'App', 1759465105, 1),
(12, '2025-10-01-120000', 'App\\Database\\Migrations\\FixPresensiGuruTable', 'default', 'App', 1759465105, 1),
(13, '2025-10-01-140000', 'App\\Database\\Migrations\\CreateMapelTable', 'default', 'App', 1759465105, 1),
(14, '2025-10-01-140100', 'App\\Database\\Migrations\\CreateNilaiTable', 'default', 'App', 1759465105, 1),
(15, '2025-10-01-140200', 'App\\Database\\Migrations\\ImproveGuruUsersIntegration', 'default', 'App', 1759465106, 1),
(16, '2025-10-02-121715', 'App\\Database\\Migrations\\AddWhatsappSettingsToGeneralSettings', 'default', 'App', 1759465106, 1),
(17, '2025-10-02-124051', 'App\\Database\\Migrations\\AddGuruWhatsappTemplates', 'default', 'App', 1759465106, 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_jurusan`
--

INSERT INTO `tb_jurusan` (`id`, `jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(6, 'Iqro 4-6', '2025-10-03 04:24:56', '2025-10-03 04:24:56', NULL),
(5, 'Iqro 1-3', '2025-10-03 04:24:45', '2025-10-03 04:24:45', NULL),
(7, 'Al-Quran', '2025-10-03 04:25:07', '2025-10-03 04:25:07', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `kelas`, `id_jurusan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(15, '3', 7, '2025-10-03 04:25:31', '2025-10-03 04:25:31', NULL),
(14, '2', 6, '2025-10-03 04:25:23', '2025-10-03 04:25:23', NULL),
(13, '1', 5, '2025-10-03 04:25:16', '2025-10-03 04:25:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_mapel`
--

DROP TABLE IF EXISTS `tb_mapel`;
CREATE TABLE IF NOT EXISTS `tb_mapel` (
  `id_mapel` int(11) NOT NULL AUTO_INCREMENT,
  `nama_mapel` varchar(100) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `id_guru` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_mapel`),
  KEY `id_guru` (`id_guru`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

DROP TABLE IF EXISTS `tb_nilai`;
CREATE TABLE IF NOT EXISTS `tb_nilai` (
  `id_nilai` int(11) NOT NULL AUTO_INCREMENT,
  `id_siswa` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `tahun_ajaran` varchar(9) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_nilai`),
  KEY `id_siswa` (`id_siswa`),
  KEY `id_mapel` (`id_mapel`),
  KEY `id_kelas` (`id_kelas`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi_guru`
--

DROP TABLE IF EXISTS `tb_presensi_guru`;
CREATE TABLE IF NOT EXISTS `tb_presensi_guru` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `id_guru` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL DEFAULT 1,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_presensi`),
  KEY `id_guru` (`id_guru`),
  KEY `id_kehadiran` (`id_kehadiran`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

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
  `foto` varchar(255) DEFAULT NULL,
  `unique_code` varchar(64) NOT NULL,
  `nama_orang_tua` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tahun_masuk` year(4) DEFAULT NULL,
  PRIMARY KEY (`id_siswa`),
  UNIQUE KEY `unique_code` (`unique_code`),
  KEY `id_kelas` (`id_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `nuptk` varchar(24) DEFAULT NULL,
  `nama_lengkap` varchar(255) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(32) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `unique_code` varchar(64) DEFAULT NULL,
  `role` enum('superadmin','guru') DEFAULT 'guru',
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`) USING HASH
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `nuptk`, `nama_lengkap`, `jenis_kelamin`, `alamat`, `no_hp`, `foto`, `unique_code`, `role`, `is_superadmin`, `password_hash`, `reset_hash`, `reset_at`, `reset_expires`, `activate_hash`, `status`, `status_message`, `active`, `force_pass_reset`, `created_at`, `updated_at`) VALUES
(1, 'adminsuper@gmail.com', 'superadmin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'superadmin', 1, '$2y$10$Qv0wpYxhn7Kd2zUpF7B4W.8OJfAwCWlVCq.rFmYA.55JORDUhTCOW', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2025-10-03 11:18:57');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
