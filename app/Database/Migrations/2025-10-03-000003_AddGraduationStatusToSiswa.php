<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGraduationStatusToSiswa extends Migration
{
    public function up()
    {
        // Check if column already exists
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_siswa' 
            AND COLUMN_NAME = 'is_graduated'
        ");
        
        // Only add column if it doesn't exist
        if ($query->getNumRows() == 0) {
            // Add graduation status column to tb_siswa table
            $this->forge->addColumn('tb_siswa', [
                'is_graduated' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'null' => false,
                    'default' => 0,
                    'comment' => 'Status kelulusan siswa: 0 = belum lulus, 1 = sudah lulus',
                    'after' => 'foto'
                ]
            ]);
        }
    }

    public function down()
    {
        // Check if column exists before dropping
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_siswa' 
            AND COLUMN_NAME = 'is_graduated'
        ");
        
        // Only drop column if it exists
        if ($query->getNumRows() > 0) {
            // Remove graduation status column from tb_siswa table
            $this->forge->dropColumn('tb_siswa', 'is_graduated');
        }
    }
}