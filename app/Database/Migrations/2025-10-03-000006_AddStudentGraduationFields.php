<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudentGraduationFields extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Check if is_graduated column already exists
        $graduationStatusQuery = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_siswa' 
            AND COLUMN_NAME = 'is_graduated'
        ");
        
        // Add is_graduated column if it doesn't exist
        if ($graduationStatusQuery->getNumRows() == 0) {
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
        
        // Check if tahun_lulus column already exists
        $graduationYearQuery = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_siswa' 
            AND COLUMN_NAME = 'tahun_lulus'
        ");
        
        // Add tahun_lulus column if it doesn't exist
        if ($graduationYearQuery->getNumRows() == 0) {
            $this->forge->addColumn('tb_siswa', [
                'tahun_lulus' => [
                    'type' => 'YEAR',
                    'constraint' => 4,
                    'null' => true,
                    'comment' => 'Tahun kelulusan siswa',
                    'after' => 'tahun_masuk'
                ]
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        
        // Check if is_graduated column exists before dropping
        $graduationStatusQuery = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_siswa' 
            AND COLUMN_NAME = 'is_graduated'
        ");
        
        if ($graduationStatusQuery->getNumRows() > 0) {
            $this->forge->dropColumn('tb_siswa', 'is_graduated');
        }
        
        // Check if tahun_lulus column exists before dropping
        $graduationYearQuery = $db->query("
            SELECT COLUMN_NAME 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_siswa' 
            AND COLUMN_NAME = 'tahun_lulus'
        ");
        
        if ($graduationYearQuery->getNumRows() > 0) {
            $this->forge->dropColumn('tb_siswa', 'tahun_lulus');
        }
    }
}