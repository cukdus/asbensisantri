<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGuruWhatsappTemplates extends Migration
{
    public function up()
    {
        $this->forge->addColumn('general_settings', [
            'wa_template_guru_masuk' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Template WhatsApp untuk guru absen masuk'
            ],
            'wa_template_guru_pulang' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Template WhatsApp untuk guru absen pulang'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('general_settings', ['wa_template_guru_masuk', 'wa_template_guru_pulang']);
    }
}
