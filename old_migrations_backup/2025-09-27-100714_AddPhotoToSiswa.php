<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPhotoToSiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_siswa', [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'no_hp'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_siswa', 'foto');
    }
}
