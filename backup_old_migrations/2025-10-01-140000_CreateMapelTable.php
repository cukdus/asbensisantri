<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMapelTable extends Migration
{
    public function up()
    {
        // Create tb_mapel table
        $this->forge->addField([
            'id_mapel' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
                'auto_increment' => true,
            ],
            'nama_mapel' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'id_guru' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => false,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_mapel', true);
        $this->forge->addKey('id_guru');
        $this->forge->createTable('tb_mapel');

        // Add foreign key constraint
        $this->forge->addForeignKey('id_guru', 'users', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropTable('tb_mapel');
    }
}