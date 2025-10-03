<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixPresensiGuruTable extends Migration
{
    public function up()
    {
        // Drop existing table if exists to recreate with proper structure
        $this->forge->dropTable('tb_presensi_guru', true);

        // Create tb_presensi_guru table with proper structure
        $this->forge->addField([
            'id_presensi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => false,
                'auto_increment' => true,
            ],
            'id_guru' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam_masuk' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_keluar' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'id_kehadiran' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => false,
                'default'    => 1,
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_presensi', true);
        $this->forge->addKey('id_guru');
        $this->forge->addKey('id_kehadiran');
        
        $this->forge->createTable('tb_presensi_guru');

        // Add foreign key constraints if the referenced tables exist
        if ($this->db->tableExists('users')) {
            $this->forge->addForeignKey('id_guru', 'users', 'id', 'CASCADE', 'CASCADE');
        }
        
        if ($this->db->tableExists('tb_kehadiran')) {
            $this->forge->addForeignKey('id_kehadiran', 'tb_kehadiran', 'id_kehadiran', 'CASCADE', 'CASCADE');
        }
    }

    public function down()
    {
        // Drop the table
        $this->forge->dropTable('tb_presensi_guru');
    }
}