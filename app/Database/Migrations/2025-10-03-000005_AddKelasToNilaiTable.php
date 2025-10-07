<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKelasToNilaiTable extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Check if id_kelas column already exists
        $query = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_nilai' 
            AND COLUMN_NAME = 'id_kelas'
        ");
        
        // Only add column if it doesn't exist
        if ($query->getNumRows() == 0) {
            // Add id_kelas column to tb_nilai table
            $this->forge->addColumn('tb_nilai', [
                'id_kelas' => [
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => true,
                    'null' => false,
                    'comment' => 'ID kelas untuk nilai siswa',
                    'after' => 'id_mapel'
                ]
            ]);

            // Add index for id_kelas
            $this->forge->addKey('id_kelas');
            $this->forge->processIndexes('tb_nilai');

            // Update existing records to set id_kelas based on student's current class
            $this->db->query('
                UPDATE tb_nilai 
                SET id_kelas = (
                    SELECT id_kelas 
                    FROM tb_siswa 
                    WHERE tb_siswa.id_siswa = tb_nilai.id_siswa
                )
                WHERE id_kelas = 0 OR id_kelas IS NULL
            ');
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // Check if id_kelas column exists before dropping
        $query = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_nilai' 
            AND COLUMN_NAME = 'id_kelas'
        ");
        
        // Only drop column if it exists
        if ($query->getNumRows() > 0) {
            $this->forge->dropColumn('tb_nilai', 'id_kelas');
        }
    }
}
