<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Myth\Auth\Password;

class InitialDataSeeding extends Migration
{
    public function up()
    {
        $this->seedKehadiranData();
        $this->seedJurusanData();
        $this->seedKelasData();
        $this->seedGeneralSettingsData();
        $this->seedSuperadminUser();
    }

    public function down()
    {
        // Clear seeded data
        $this->db->table('users')->truncate();
        $this->db->table('tb_kelas')->truncate();
        $this->db->table('tb_jurusan')->truncate();
        $this->db->table('tb_kehadiran')->truncate();
        $this->db->table('general_settings')->truncate();
    }

    private function seedKehadiranData()
    {
        // Insert data one by one to ensure proper ID assignment
        $this->db->table('tb_kehadiran')->insert(['kehadiran' => 'Hadir']);
        $this->db->table('tb_kehadiran')->insert(['kehadiran' => 'Sakit']);
        $this->db->table('tb_kehadiran')->insert(['kehadiran' => 'Izin']);
        $this->db->table('tb_kehadiran')->insert(['kehadiran' => 'Tanpa keterangan']);
    }

    private function seedJurusanData()
    {
        $data = [
            [
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'jurusan' => 'Teknik Komputer dan Jaringan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'jurusan' => 'Multimedia',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('tb_jurusan')->insertBatch($data);
    }

    private function seedKelasData()
    {
        $data = [
            [
                'kelas' => 'X RPL 1',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'X RPL 2',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XI RPL 1',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XI RPL 2',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XII RPL 1',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XII RPL 2',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'X TKJ 1',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'X TKJ 2',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XI TKJ 1',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XI TKJ 2',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XII TKJ 1',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XII TKJ 2',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'X MM 1',
                'id_jurusan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'X MM 2',
                'id_jurusan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XI MM 1',
                'id_jurusan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XI MM 2',
                'id_jurusan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XII MM 1',
                'id_jurusan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => 'XII MM 2',
                'id_jurusan' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('tb_kelas')->insertBatch($data);
    }

    private function seedGeneralSettingsData()
    {
        $data = [
            'logo' => null,
            'school_name' => 'SMK 1 Indonesia',
            'school_year' => '2024/2025',
            'copyright' => '© 2025 All rights reserved.',
            'waha_api_url' => 'http://localhost:3000',
            'waha_api_key' => null,
            'waha_x_api_key' => null,
            'wa_template_masuk' => 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.',
            'wa_template_pulang' => 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.',
            'wa_template_guru_masuk' => null,
            'wa_template_guru_pulang' => null
        ];

        $this->db->table('general_settings')->insert($data);
    }

    private function seedSuperadminUser()
    {
        // Create superadmin user
        $email = 'adminsuper@gmail.com';
        $username = 'superadmin';
        $password = 'superadmin';

        // Hash the password using Myth\Auth\Password for compatibility
        $encryptedPassword = \Myth\Auth\Password::hash($password);

        $userData = [
            'email' => $email,
            'username' => $username,
            'is_superadmin' => 1,
            'password_hash' => $encryptedPassword,
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->table('users')->insert($userData);
    }
}