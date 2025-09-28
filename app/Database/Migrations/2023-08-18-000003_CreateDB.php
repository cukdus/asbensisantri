<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDB extends Migration
{
    public function up()
    {
        // Cek apakah tabel sudah ada sebelum membuat
        if (!$this->db->tableExists('tb_kehadiran')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_kehadiran (
                id_kehadiran int(11) NOT NULL,
                kehadiran ENUM('Hadir', 'Sakit', 'Izin', 'Tanpa keterangan') NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
            
        if (!$this->db->tableExists('tb_jurusan')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_jurusan (
                id_jurusan int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                jurusan varchar(50) NOT NULL,
                PRIMARY KEY (id_jurusan)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
            
        if (!$this->db->tableExists('tb_kelas')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_kelas (
                id_kelas int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                kelas varchar(10) NOT NULL,
                id_jurusan int(11) UNSIGNED NOT NULL,
                PRIMARY KEY (id_kelas),
                KEY id_jurusan (id_jurusan),
                CONSTRAINT tb_kelas_ibfk_1 FOREIGN KEY (id_jurusan) REFERENCES tb_jurusan (id_jurusan) ON DELETE CASCADE ON UPDATE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Cek apakah data sudah ada di tabel kehadiran
        $kehadiranCount = $this->db->table('tb_kehadiran')->countAllResults();
        if ($kehadiranCount == 0) {
            $this->forge->getConnection()->query("INSERT INTO tb_kehadiran (id_kehadiran, kehadiran) VALUES
                (1, 'Hadir'),
                (2, 'Sakit'),
                (3, 'Izin'),
                (4, 'Tanpa keterangan');");
        }

        // Cek apakah data sudah ada di tabel jurusan
        $jurusanCount = $this->db->table('tb_jurusan')->countAllResults();
        if ($jurusanCount == 0) {
            $this->forge->getConnection()->query("INSERT INTO tb_jurusan (jurusan) VALUES
                ('OTKP'),
                ('BDP'),
                ('AKL'),
                ('RPL');");
        }

        // Cek apakah data sudah ada di tabel kelas
        $kelasCount = $this->db->table('tb_kelas')->countAllResults();
        if ($kelasCount == 0) {
            $this->forge->getConnection()->query("INSERT INTO tb_kelas (kelas, id_jurusan) VALUES
                ('X', 1),
                ('X', 2),
                ('X', 3),
                ('X', 4),
                ('XI', 1),
                ('XI', 2),
                ('XI', 3),
                ('XI', 4),
                ('XII', 1),
                ('XII', 2),
                ('XII', 3),
                ('XII', 4);");
        }

        if (!$this->db->tableExists('tb_guru')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_guru (
                id_guru int(11) NOT NULL,
                nuptk varchar(24) NOT NULL,
                nama_guru varchar(255) NOT NULL,
                jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
                alamat text NOT NULL,
                no_hp varchar(32) NOT NULL,
                unique_code varchar(64) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->tableExists('tb_presensi_guru')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_presensi_guru (
                id_presensi int(11) NOT NULL,
                id_guru int(11) DEFAULT NULL,
                tanggal date NOT NULL,
                jam_masuk time DEFAULT NULL,
                jam_keluar time DEFAULT NULL,
                id_kehadiran int(11) NOT NULL,
                keterangan varchar(255) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                            ");
        }

        if (!$this->db->tableExists('tb_siswa')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_siswa (
                id_siswa int(11) NOT NULL,
                nis varchar(16) NOT NULL,
                nama_siswa varchar(255) NOT NULL,
                id_kelas int(11) UNSIGNED NOT NULL,
                jenis_kelamin ENUM('Laki-laki','Perempuan') NOT NULL,
                no_hp varchar(32) NOT NULL,
                unique_code varchar(64) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        if (!$this->db->tableExists('tb_presensi_siswa')) {
            $this->forge->getConnection()->query("CREATE TABLE tb_presensi_siswa (
                id_presensi int(11) NOT NULL,
                id_siswa int(11) NOT NULL,
                id_kelas int(11) UNSIGNED DEFAULT NULL,
                tanggal date NOT NULL,
                jam_masuk time DEFAULT NULL,
                jam_keluar time DEFAULT NULL,
                id_kehadiran int(11) NOT NULL,
                keterangan varchar(255) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Tambahkan primary key dan constraint hanya jika belum ada
        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_guru
                ADD PRIMARY KEY (id_guru),
                ADD UNIQUE KEY unique_code (unique_code);");
        } catch (\Exception $e) {
            // Primary key mungkin sudah ada, abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_kehadiran
                ADD PRIMARY KEY (id_kehadiran);");
        } catch (\Exception $e) {
            // Primary key mungkin sudah ada, abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_presensi_guru
                ADD PRIMARY KEY (id_presensi),
                ADD KEY id_kehadiran (id_kehadiran),
                ADD KEY id_guru (id_guru);");
        } catch (\Exception $e) {
            // Primary key mungkin sudah ada, abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_presensi_siswa
                ADD PRIMARY KEY (id_presensi),
                ADD KEY id_siswa (id_siswa),
                ADD KEY id_kehadiran (id_kehadiran),
                ADD KEY id_kelas (id_kelas);");
        } catch (\Exception $e) {
            // Primary key mungkin sudah ada, abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_siswa
                ADD PRIMARY KEY (id_siswa),
                ADD UNIQUE KEY unique_code (unique_code),
                ADD KEY id_kelas (id_kelas);");
        } catch (\Exception $e) {
            // Primary key mungkin sudah ada, abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_guru
                MODIFY id_guru int(11) NOT NULL AUTO_INCREMENT;");
        } catch (\Exception $e) {
            // Abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_kehadiran
                MODIFY id_kehadiran int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;");
        } catch (\Exception $e) {
            // Abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_presensi_guru
                MODIFY id_presensi int(11) NOT NULL AUTO_INCREMENT;");
        } catch (\Exception $e) {
            // Abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_presensi_siswa
                MODIFY id_presensi int(11) NOT NULL AUTO_INCREMENT;");
        } catch (\Exception $e) {
            // Abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_siswa
                MODIFY id_siswa int(11) NOT NULL AUTO_INCREMENT;");
        } catch (\Exception $e) {
            // Abaikan error
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_presensi_guru
                ADD CONSTRAINT tb_presensi_guru_ibfk_2 FOREIGN KEY (id_kehadiran) REFERENCES tb_kehadiran (id_kehadiran),
                ADD CONSTRAINT tb_presensi_guru_ibfk_3 FOREIGN KEY (id_guru) REFERENCES tb_guru (id_guru) ON DELETE SET NULL;");
        } catch (\Exception $e) {
            // Abaikan error foreign key yang mungkin sudah ada
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_presensi_siswa
                ADD CONSTRAINT tb_presensi_siswa_ibfk_2 FOREIGN KEY (id_kehadiran) REFERENCES tb_kehadiran (id_kehadiran),
                ADD CONSTRAINT tb_presensi_siswa_ibfk_3 FOREIGN KEY (id_siswa) REFERENCES tb_siswa (id_siswa) ON DELETE CASCADE,
                ADD CONSTRAINT tb_presensi_siswa_ibfk_4 FOREIGN KEY (id_kelas) REFERENCES tb_kelas (id_kelas) ON DELETE SET NULL ON UPDATE CASCADE;");
        } catch (\Exception $e) {
            // Abaikan error foreign key yang mungkin sudah ada
        }

        try {
            $this->forge->getConnection()->query("ALTER TABLE tb_siswa
                ADD CONSTRAINT tb_siswa_ibfk_1 FOREIGN KEY (id_kelas) REFERENCES tb_kelas (id_kelas);");
        } catch (\Exception $e) {
            // Abaikan error foreign key yang mungkin sudah ada
        }
    }

    public function down()
    {
        $tables = [
            'tb_presensi_siswa',
            'tb_presensi_guru',
            'tb_siswa',
            'tb_guru',
            'tb_kehadiran',
        ];

        foreach ($tables as $table) {
            $this->forge->dropTable($table);
        }
    }
}
