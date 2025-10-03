<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToUsers extends Migration
{
    public function up()
    {
        // Add foto column to users table
        $this->forge->addColumn('users', [
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
        // Remove foto column from users table
        $this->forge->dropColumn('users', 'foto');
    }
}