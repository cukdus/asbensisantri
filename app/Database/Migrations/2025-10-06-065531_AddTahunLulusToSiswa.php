<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTahunLulusToSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_siswa', [
            'tahun_lulus' => [
                'type' => 'YEAR',
                'constraint' => 4,
                'null' => true,
                'after' => 'tahun_masuk'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_siswa', 'tahun_lulus');
    }
}
