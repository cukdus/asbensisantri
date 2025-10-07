-- Script untuk memperbaiki struktur tabel tb_presensi_guru

-- Cek apakah tabel sudah ada, jika belum maka buat tabel baru
CREATE TABLE IF NOT EXISTS `tb_presensi_guru` (
  `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  `id_guru` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `id_kehadiran` int(11) NOT NULL DEFAULT 1,
  `keterangan` text DEFAULT NULL,
  PRIMARY KEY (`id_presensi`),
  KEY `id_guru` (`id_guru`),
  KEY `id_kehadiran` (`id_kehadiran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Jika tabel sudah ada, pastikan semua kolom yang diperlukan tersedia
ALTER TABLE `tb_presensi_guru` 
  MODIFY COLUMN `id_presensi` int(11) NOT NULL AUTO_INCREMENT,
  MODIFY COLUMN `id_guru` int(11) NOT NULL,
  MODIFY COLUMN `tanggal` date NOT NULL,
  MODIFY COLUMN `jam_masuk` time DEFAULT NULL,
  MODIFY COLUMN `jam_keluar` time DEFAULT NULL,
  MODIFY COLUMN `id_kehadiran` int(11) NOT NULL DEFAULT 1,
  MODIFY COLUMN `keterangan` text DEFAULT NULL;

-- Tambahkan indeks jika belum ada
ALTER TABLE `tb_presensi_guru` ADD INDEX IF NOT EXISTS `idx_id_guru` (`id_guru`);
ALTER TABLE `tb_presensi_guru` ADD INDEX IF NOT EXISTS `idx_id_kehadiran` (`id_kehadiran`);