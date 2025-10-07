<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganToNilai extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Check if keterangan column already exists
        $query = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_nilai' 
            AND COLUMN_NAME = 'keterangan'
        ");
        
        // Only add column if it doesn't exist
        if ($query->getNumRows() == 0) {
            $this->forge->addColumn('tb_nilai', [
                'keterangan' => [
                    'type' => 'TEXT',
                    'null' => true,
                    'comment' => 'Keterangan tambahan untuk nilai siswa',
                    'after' => 'tahun_ajaran'
                ]
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // Check if keterangan column exists before dropping
        $query = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_nilai' 
            AND COLUMN_NAME = 'keterangan'
        ");
        
        // Only drop column if it exists
        if ($query->getNumRows() > 0) {
            $this->forge->dropColumn('tb_nilai', 'keterangan');
        }
    }
}