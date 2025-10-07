<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudentAdditionalFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_siswa', [
            'nama_orang_tua' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'tahun_masuk' => [
                'type' => 'YEAR',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_siswa', ['nama_orang_tua', 'alamat', 'tahun_masuk']);
    }
}