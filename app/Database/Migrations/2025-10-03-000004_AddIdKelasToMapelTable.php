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
        // Drop foreign key constraint first
        $this->forge->dropForeignKey('tb_mapel', 'fk_mapel_kelas');
        
        // Drop the column
        $this->forge->dropColumn('tb_mapel', 'id_kelas');
    }
}