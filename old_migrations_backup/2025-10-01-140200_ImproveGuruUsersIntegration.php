<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImproveGuruUsersIntegration extends Migration
{
    public function up()
    {
        // Ensure users table has all necessary fields for guru integration
        $fields = [];
        
        // Check if fields exist before adding them
        if (!$this->db->fieldExists('nuptk', 'users')) {
            $fields['nuptk'] = [
                'type' => 'VARCHAR',
                'constraint' => 24,
                'null' => true,
                'after' => 'username'
            ];
        }
        
        if (!$this->db->fieldExists('nama_lengkap', 'users')) {
            $fields['nama_lengkap'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'nuptk'
            ];
        }
        
        if (!$this->db->fieldExists('jenis_kelamin', 'users')) {
            $fields['jenis_kelamin'] = [
                'type' => 'ENUM',
                'constraint' => ['Laki-laki', 'Perempuan'],
                'null' => true,
                'after' => 'nama_lengkap'
            ];
        }
        
        if (!$this->db->fieldExists('alamat', 'users')) {
            $fields['alamat'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'jenis_kelamin'
            ];
        }
        
        if (!$this->db->fieldExists('no_hp', 'users')) {
            $fields['no_hp'] = [
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null' => true,
                'after' => 'alamat'
            ];
        }
        
        if (!$this->db->fieldExists('unique_code', 'users')) {
            $fields['unique_code'] = [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
                'after' => 'no_hp'
            ];
        }
        
        if (!$this->db->fieldExists('role', 'users')) {
            $fields['role'] = [
                'type' => 'ENUM',
                'constraint' => ['superadmin', 'guru'],
                'default' => 'guru',
                'after' => 'unique_code'
            ];
        }

        // Add fields if any are missing
        if (!empty($fields)) {
            $this->forge->addColumn('users', $fields);
        }

        // Add unique index for unique_code if it doesn't exist
        try {
            $this->forge->addKey('unique_code', false, true, 'users');
        } catch (Exception $e) {
            // Index might already exist, ignore the error
        }

        // Migrate data from tb_guru to users table if not already done
        $this->migrateGuruDataSafely();

        // Update tb_presensi_guru to reference users table instead of tb_guru
        $this->updatePresensiGuruReferences();
        
        // Update tb_mapel to reference users table instead of tb_guru
        $this->updateMapelReferences();
    }

    public function down()
    {
        // Revert changes - this is complex due to data migration
        // For safety, we'll just remove the added columns
        $columnsToRemove = ['nuptk', 'nama_lengkap', 'jenis_kelamin', 'alamat', 'no_hp', 'unique_code', 'role'];
        
        foreach ($columnsToRemove as $column) {
            if ($this->db->fieldExists($column, 'users')) {
                $this->forge->dropColumn('users', $column);
            }
        }
    }

    private function migrateGuruDataSafely()
    {
        // Check if tb_guru table exists
        if (!$this->db->tableExists('tb_guru')) {
            return;
        }

        // Get all guru data
        $guruData = $this->db->table('tb_guru')->get()->getResultArray();

        foreach ($guruData as $guru) {
            // Check if user with this unique_code already exists
            $existingUser = $this->db->table('users')
                ->where('unique_code', $guru['unique_code'])
                ->get()
                ->getRowArray();

            if (!$existingUser) {
                // Generate unique email and username
                $baseEmail = strtolower(str_replace(' ', '.', $guru['nama_guru']));
                $baseUsername = strtolower(str_replace(' ', '', $guru['nama_guru']));
                
                // Ensure uniqueness
                $email = $baseEmail . '@sekolah.com';
                $username = $baseUsername;
                $counter = 1;
                
                while ($this->db->table('users')->where('email', $email)->get()->getRowArray()) {
                    $email = $baseEmail . $counter . '@sekolah.com';
                    $counter++;
                }
                
                $counter = 1;
                while ($this->db->table('users')->where('username', $username)->get()->getRowArray()) {
                    $username = $baseUsername . $counter;
                    $counter++;
                }

                // Create new user record for each guru
                $userData = [
                    'email' => $email,
                    'username' => $username,
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

        // Update existing users to have proper roles
        $this->db->table('users')
            ->where('is_superadmin', 1)
            ->set(['role' => 'superadmin'])
            ->update();

        $this->db->table('users')
            ->where('role IS NULL OR role = ""')
            ->where('is_superadmin', 0)
            ->set(['role' => 'guru'])
            ->update();
    }

    private function updatePresensiGuruReferences()
    {
        // Add user_id field to tb_presensi_guru if it doesn't exist
        if ($this->db->tableExists('tb_presensi_guru') && !$this->db->fieldExists('user_id', 'tb_presensi_guru')) {
            $this->forge->addColumn('tb_presensi_guru', [
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'id_presensi'
                ]
            ]);

            // Update existing records to use user_id instead of id_guru
            // Only if tb_guru table exists
            if ($this->db->tableExists('tb_guru')) {
                $sql = "SELECT tb_presensi_guru.*, users.id as user_id 
                        FROM tb_presensi_guru 
                        LEFT JOIN tb_guru ON tb_guru.id_guru = tb_presensi_guru.id_guru 
                        LEFT JOIN users ON users.unique_code COLLATE utf8mb4_general_ci = tb_guru.unique_code COLLATE utf8mb4_general_ci 
                        WHERE tb_presensi_guru.user_id IS NULL";
                $presensiData = $this->db->query($sql)->getResultArray();

                foreach ($presensiData as $presensi) {
                    if ($presensi['user_id']) {
                        $this->db->table('tb_presensi_guru')
                            ->where('id_presensi', $presensi['id_presensi'])
                            ->update(['user_id' => $presensi['user_id']]);
                    }
                }
            }
            // If tb_guru doesn't exist, skip the data migration
        }
    }

    private function updateMapelReferences()
    {
        // Add user_id field to tb_mapel if it doesn't exist
        if ($this->db->tableExists('tb_mapel') && !$this->db->fieldExists('user_id', 'tb_mapel')) {
            $this->forge->addColumn('tb_mapel', [
                'user_id' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => true,
                    'after' => 'nama_mapel'
                ]
            ]);

            // Update existing records to use user_id instead of id_guru
            // Only if tb_guru table exists
            if ($this->db->tableExists('tb_guru')) {
                $sql = "SELECT tb_mapel.*, users.id as user_id 
                        FROM tb_mapel 
                        LEFT JOIN tb_guru ON tb_guru.id_guru = tb_mapel.id_guru 
                        LEFT JOIN users ON users.unique_code COLLATE utf8mb4_general_ci = tb_guru.unique_code COLLATE utf8mb4_general_ci 
                        WHERE tb_mapel.user_id IS NULL";
                $mapelData = $this->db->query($sql)->getResultArray();

                foreach ($mapelData as $mapel) {
                    if ($mapel['user_id']) {
                        $this->db->table('tb_mapel')
                            ->where('id_mapel', $mapel['id_mapel'])
                            ->update(['user_id' => $mapel['user_id']]);
                    }
                }
            }
            // If tb_guru doesn't exist, skip the data migration
        }
    }
}