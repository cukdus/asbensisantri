<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UnifyGuruPetugasUsers extends Migration
{
    public function up()
    {
        // Check existing columns in users table
        $existingFields = $this->db->getFieldData('users');
        $existingColumns = [];
        foreach ($existingFields as $field) {
            $existingColumns[] = $field->name;
        }

        // Add new fields to users table for guru integration (only if they don't exist)
        $fields = [];
        
        if (!in_array('nuptk', $existingColumns)) {
            $fields['nuptk'] = [
                'type' => 'VARCHAR',
                'constraint' => 24,
                'null' => true,
                'after' => 'username'
            ];
        }
        
        if (!in_array('nama_lengkap', $existingColumns)) {
            $fields['nama_lengkap'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'nuptk'
            ];
        }
        
        if (!in_array('jenis_kelamin', $existingColumns)) {
            $fields['jenis_kelamin'] = [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null' => true,
                'after' => 'nama_lengkap'
            ];
        }
        
        if (!in_array('alamat', $existingColumns)) {
            $fields['alamat'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'jenis_kelamin'
            ];
        }
        
        if (!in_array('no_hp', $existingColumns)) {
            $fields['no_hp'] = [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true,
                'after' => 'alamat'
            ];
        }
        
        if (!in_array('unique_code', $existingColumns)) {
            $fields['unique_code'] = [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
                'after' => 'no_hp'
            ];
        }
        
        if (!in_array('role', $existingColumns)) {
            $fields['role'] = [
                'type' => 'ENUM',
                'constraint' => ['superadmin', 'guru'],
                'default' => 'guru',
                'after' => 'unique_code'
            ];
        }

        if (!empty($fields)) {
            $this->forge->addColumn('users', $fields);
        }

        // Add unique index for unique_code
        $this->forge->addKey('unique_code', false, true);

        // Migrate data from tb_guru to users table
        $this->migrateGuruData();

        // Update existing users to have superadmin role
        $this->updateExistingUsers();
    }

    public function down()
    {
        // Remove added columns
        $this->forge->dropColumn('users', ['nuptk', 'nama_lengkap', 'jenis_kelamin', 'alamat', 'no_hp', 'unique_code', 'role']);
    }

    private function migrateGuruData()
    {
        // Skip guru data migration since tb_guru table has been removed
        // Guru data will be populated via GuruSeeder instead
        
        // Check if tb_guru table exists before attempting migration
        if ($this->db->tableExists('tb_guru')) {
            // Get all guru data
            $guruData = $this->db->table('tb_guru')->get()->getResultArray();

            foreach ($guruData as $guru) {
                // Check if user with this unique_code already exists
                $existingUser = $this->db->table('users')
                    ->where('unique_code', $guru['unique_code'])
                    ->get()
                    ->getRowArray();

                if (!$existingUser) {
                    // Create new user record for each guru
                    $userData = [
                        'email' => strtolower(str_replace(' ', '.', $guru['nama_guru'])) . '@sekolah.com',
                        'username' => strtolower(str_replace(' ', '', $guru['nama_guru'])),
                        'nuptk' => $guru['nuptk'],
                        'nama_lengkap' => $guru['nama_guru'],
                        'jenis_kelamin' => $guru['jenis_kelamin'],
                        'alamat' => $guru['alamat'],
                        'no_hp' => $guru['no_hp'],
                        'unique_code' => $guru['unique_code'],
                        'role' => 'guru',
                        'password_hash' => password_hash('123456', PASSWORD_DEFAULT), // Default password
                        'active' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];

                    $this->db->table('users')->insert($userData);
                }
            }
        }
        // If tb_guru doesn't exist, skip migration (table has been removed)
    }

    private function updateExistingUsers()
    {
        // Update existing users (petugas) to have superadmin role if is_superadmin = 1
        $this->db->table('users')
            ->where('is_superadmin', 1)
            ->set(['role' => 'superadmin'])
            ->update();

        // Update other existing users to guru role if they don't have role set
        $this->db->table('users')
            ->where('role IS NULL')
            ->set(['role' => 'guru'])
            ->update();
    }
}