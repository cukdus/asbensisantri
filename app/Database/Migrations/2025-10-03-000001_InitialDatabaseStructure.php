<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class InitialDatabaseStructure extends Migration
{
    public function up()
    {
        $this->createAuthTables();
        $this->createApplicationTables();
    }

    public function down()
    {
        // Drop tables in reverse order to handle foreign key constraints
        $this->forge->dropTable('tb_nilai', true);
        $this->forge->dropTable('tb_mapel', true);
        $this->forge->dropTable('tb_presensi_guru', true);
        $this->forge->dropTable('tb_presensi_siswa', true);
        $this->forge->dropTable('tb_siswa', true);
        $this->forge->dropTable('tb_kelas', true);
        $this->forge->dropTable('tb_jurusan', true);
        $this->forge->dropTable('tb_kehadiran', true);
        $this->forge->dropTable('general_settings', true);

        // Drop auth tables
        $this->forge->dropTable('auth_activation_attempts', true);
        $this->forge->dropTable('auth_reset_attempts', true);
        $this->forge->dropTable('auth_tokens', true);
        $this->forge->dropTable('auth_logins', true);
        $this->forge->dropTable('auth_users_permissions', true);
        $this->forge->dropTable('auth_groups_users', true);
        $this->forge->dropTable('auth_groups_permissions', true);
        $this->forge->dropTable('auth_permissions', true);
        $this->forge->dropTable('auth_groups', true);
        $this->forge->dropTable('users', true);
    }

    private function createAuthTables()
    {
        // Create users table (enhanced with guru fields)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true
            ],
            'nuptk' => [
                'type' => 'VARCHAR',
                'constraint' => 24,
                'null' => true
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null' => true
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'unique_code' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['superadmin', 'guru'],
                'default' => 'guru'
            ],
            'is_superadmin' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => '1 = superadmin, 0 = bukan',
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'reset_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'reset_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'reset_expires' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'activate_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'status_message' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'force_pass_reset' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // Create auth_groups table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_groups', true);

        // Create auth_permissions table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_permissions', true);

        // Create auth_groups_permissions table
        $this->forge->addField([
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'permission_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ]
        ]);
        $this->forge->addKey(['group_id', 'permission_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_groups_permissions', true);

        // Create auth_groups_users table
        $this->forge->addField([
            'group_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ]
        ]);
        $this->forge->addKey(['group_id', 'user_id']);
        $this->forge->addForeignKey('group_id', 'auth_groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_groups_users', true);

        // Create auth_users_permissions table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ],
            'permission_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default' => 0
            ]
        ]);
        $this->forge->addKey(['user_id', 'permission_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'auth_permissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_users_permissions', true);

        // Create auth_logins table (with login field for username/email tracking)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'login' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Stores the actual login value (email or username)'
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'date' => [
                'type' => 'DATETIME',
                'null' => false
            ],
            'success' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->addKey('user_id');
        $this->forge->createTable('auth_logins', true);

        // Create auth_tokens table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'selector' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'hashedValidator' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'expires' => [
                'type' => 'DATETIME',
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('selector');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('auth_tokens', true);

        // Create auth_reset_attempts table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_reset_attempts', true);

        // Create auth_activation_attempts table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'user_agent' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('auth_activation_attempts', true);
    }

    private function createApplicationTables()
    {
        // Create tb_jurusan table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => false
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'deleted_at TIMESTAMP NULL'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('jurusan');
        $this->forge->createTable('tb_jurusan', true);

        // Create tb_kelas table
        $this->forge->addField([
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => false
            ],
            'id_jurusan' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NULL',
            'deleted_at TIMESTAMP NULL'
        ]);
        $this->forge->addKey('id_kelas', true);
        $this->forge->addKey('id_jurusan');
        $this->forge->addForeignKey('id_jurusan', 'tb_jurusan', 'id', 'CASCADE', 'NO ACTION');
        $this->forge->createTable('tb_kelas', true);

        // Create tb_kehadiran table
        $this->forge->addField([
            'id_kehadiran' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'kehadiran' => [
                'type' => 'ENUM',
                'constraint' => ['Hadir', 'Sakit', 'Izin', 'Tanpa keterangan'],
                'null' => false
            ]
        ]);
        $this->forge->addKey('id_kehadiran', true);
        $this->forge->createTable('tb_kehadiran', true);

        // Create tb_siswa table
        $this->forge->addField([
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 16,
                'null' => false
            ],
            'nama_siswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null' => false
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => false
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'is_graduated' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'null' => false,
                'default' => 0,
                'comment' => 'Status kelulusan siswa: 0 = belum lulus, 1 = sudah lulus'
            ],
            'unique_code' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => false
            ],
            'nama_orang_tua' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tahun_masuk' => [
                'type' => 'YEAR',
                'null' => true
            ],
            'tahun_lulus' => [
                'type' => 'YEAR',
                'constraint' => 4,
                'null' => true,
                'comment' => 'Tahun kelulusan siswa'
            ]
        ]);
        $this->forge->addKey('id_siswa', true);
        $this->forge->addUniqueKey('unique_code');
        $this->forge->addKey('id_kelas');
        $this->forge->addForeignKey('id_kelas', 'tb_kelas', 'id_kelas');
        $this->forge->createTable('tb_siswa', true);

        // Create tb_presensi_siswa table
        $this->forge->addField([
            'id_presensi' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false
            ],
            'jam_masuk' => [
                'type' => 'TIME',
                'null' => true
            ],
            'jam_keluar' => [
                'type' => 'TIME',
                'null' => true
            ],
            'id_kehadiran' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false
            ]
        ]);
        $this->forge->addKey('id_presensi', true);
        $this->forge->addKey('id_siswa');
        $this->forge->addKey('id_kehadiran');
        $this->forge->addKey('id_kelas');
        $this->forge->addForeignKey('id_kehadiran', 'tb_kehadiran', 'id_kehadiran');
        $this->forge->addForeignKey('id_siswa', 'tb_siswa', 'id_siswa', 'CASCADE');
        $this->forge->addForeignKey('id_kelas', 'tb_kelas', 'id_kelas', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tb_presensi_siswa', true);

        // Create tb_presensi_guru table
        $this->forge->addField([
            'id_presensi' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'id_guru' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'tanggal' => [
                'type' => 'DATE',
                'null' => false
            ],
            'jam_masuk' => [
                'type' => 'TIME',
                'null' => true
            ],
            'jam_keluar' => [
                'type' => 'TIME',
                'null' => true
            ],
            'id_kehadiran' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id_presensi', true);
        $this->forge->addKey('id_guru');
        $this->forge->addKey('id_kehadiran');
        $this->forge->addForeignKey('id_kehadiran', 'tb_kehadiran', 'id_kehadiran');
        $this->forge->createTable('tb_presensi_guru', true);

        // Create tb_mapel table
        $this->forge->addField([
            'id_mapel' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'nama_mapel' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'id_guru' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ]
        ]);
        $this->forge->addKey('id_mapel', true);
        $this->forge->addKey('id_guru');
        $this->forge->addKey('id_kelas');
        $this->forge->addForeignKey('id_kelas', 'tb_kelas', 'id_kelas', 'CASCADE', 'SET NULL');
        $this->forge->createTable('tb_mapel', true);

        // Create tb_nilai table
        $this->forge->addField([
            'id_nilai' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true
            ],
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'id_mapel' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false
            ],
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true
            ],
            'nilai' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false
            ],
            'semester' => [
                'type' => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
                'null' => false
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => false
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Keterangan tambahan untuk nilai siswa'
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ]
        ]);
        $this->forge->addKey('id_nilai', true);
        $this->forge->addKey('id_siswa');
        $this->forge->addKey('id_mapel');
        $this->forge->addKey('id_kelas');
        $this->forge->addForeignKey('id_siswa', 'tb_siswa', 'id_siswa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_mapel', 'tb_mapel', 'id_mapel', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kelas', 'tb_kelas', 'id_kelas', 'CASCADE', 'SET NULL');
        $this->forge->createTable('tb_nilai', true);

        // Create general_settings table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'logo' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'null' => true
            ],
            'school_name' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'default' => 'SMK 1 Indonesia'
            ],
            'school_year' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'default' => '2024/2025'
            ],
            'copyright' => [
                'type' => 'VARCHAR',
                'constraint' => 225,
                'default' => '© 2025 All rights reserved.'
            ],
            'waha_api_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'default' => 'http://localhost:3000',
                'comment' => 'WAHA API URL/Link'
            ],
            'waha_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'WAHA API Key (if required)'
            ],
            'waha_x_api_key' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'WAHA X-API-Key header'
            ],
            'wa_template_masuk' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'default' => 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.',
                'comment' => 'Template pesan WhatsApp untuk absen masuk'
            ],
            'wa_template_pulang' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'default' => 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.',
                'comment' => 'Template pesan WhatsApp untuk absen pulang'
            ],
            'wa_template_guru_masuk' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true,
                'comment' => 'Template WhatsApp untuk guru absen masuk'
            ],
            'wa_template_guru_pulang' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true,
                'comment' => 'Template WhatsApp untuk guru absen pulang'
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('general_settings', true);
    }
}
