<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdKelasToMapelTable extends Migration
{
    public function up()
    {
        // Add id_kelas column to tb_mapel table
        $this->forge->addColumn('tb_mapel', [
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id_guru'
            ]
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('id_kelas', 'tb_kelas', 'id_kelas', 'CASCADE', 'SET NULL', 'fk_mapel_kelas');
    }

    public function down()
    {
        // Check if foreign key exists before dropping
        $db = \Config\Database::connect();
        $query = $db->query("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'tb_mapel' 
            AND CONSTRAINT_NAME = 'fk_mapel_kelas'
        ");
        
        if ($query->getNumRows() > 0) {
            // Drop foreign key constraint first
            $this->forge->dropForeignKey('tb_mapel', 'fk_mapel_kelas');
        }
        
        // Drop the column
        $this->forge->dropColumn('tb_mapel', 'id_kelas');
    }
}