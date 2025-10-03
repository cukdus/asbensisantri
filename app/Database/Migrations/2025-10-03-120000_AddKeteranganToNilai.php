<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeteranganToNilai extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tb_nilai', [
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'tahun_ajaran'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tb_nilai', 'keterangan');
    }
}