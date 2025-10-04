<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKelasToNilaiTable extends Migration
{
    public function up()
    {
        // Add id_kelas column to tb_nilai table
        $fields = [
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'after' => 'id_mapel'
            ]
        ];

        $this->forge->addColumn('tb_nilai', $fields);

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

    public function down()
    {
        // Remove the id_kelas column
        $this->forge->dropColumn('tb_nilai', 'id_kelas');
    }
}
