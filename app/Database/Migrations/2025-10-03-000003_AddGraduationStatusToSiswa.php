<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGraduationStatusToSiswa extends Migration
{
    public function up()
    {
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

    public function down()
    {
        // Remove graduation status column from tb_siswa table
        $this->forge->dropColumn('tb_siswa', 'is_graduated');
    }
}