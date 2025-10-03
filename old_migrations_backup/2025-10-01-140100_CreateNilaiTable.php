<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNilaiTable extends Migration
{
    public function up()
    {
        // Create tb_nilai table
        $this->forge->addField([
            'id_nilai' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
                'auto_increment' => true,
            ],
            'id_siswa' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
                'null' => false,
            ],
            'id_mapel' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
                'null' => false,
            ],
            'nilai' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
            ],
            'semester' => [
                'type' => 'ENUM',
                'constraint' => ['Ganjil', 'Genap'],
                'null' => false,
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_nilai', true);
        $this->forge->addKey('id_siswa');
        $this->forge->addKey('id_mapel');
        $this->forge->createTable('tb_nilai');

        // Add foreign key constraints
        $this->forge->addForeignKey('id_siswa', 'tb_siswa', 'id_siswa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_mapel', 'tb_mapel', 'id_mapel', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('tb_nilai');
    }
}