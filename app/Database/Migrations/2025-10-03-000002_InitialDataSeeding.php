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
                'jurusan' => 'Iqro 1-3',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'jurusan' => 'Iqro 4-6',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'jurusan' => 'Al-Quran',
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
                'kelas' => '1',
                'id_jurusan' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => '2',
                'id_jurusan' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'kelas' => '3',
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
            'school_name' => 'PP Sirojan Muniro Assalam',
            'school_year' => '2025/2026',
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

        // Check if is_superadmin column exists in users table
        $fields = $this->db->getFieldNames('users');
        $hasIsSuperadmin = in_array('is_superadmin', $fields);
        $hasRole = in_array('role', $fields);

        $userData = [
            'email' => $email,
            'username' => $username,
            'password_hash' => $encryptedPassword,
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Add is_superadmin column if it exists
        if ($hasIsSuperadmin) {
            $userData['is_superadmin'] = 1;
        }

        // Add role column if it exists
        if ($hasRole) {
            $userData['role'] = 'superadmin';
        }

        $this->db->table('users')->insert($userData);
    }
}
