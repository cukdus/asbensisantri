<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWhatsappSettingsToGeneralSettings extends Migration
{
    public function up()
    {
        $fields = [
            'waha_api_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => 'http://localhost:3000',
                'comment'    => 'WAHA API URL/Link'
            ],
            'waha_api_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'WAHA API Key (if required)'
            ],
            'waha_x_api_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'WAHA X-API-Key header'
            ],
            'wa_template_masuk' => [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.',
                'comment'    => 'Template pesan WhatsApp untuk absen masuk'
            ],
            'wa_template_pulang' => [
                'type'       => 'TEXT',
                'null'       => true,
                'default'    => 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.',
                'comment'    => 'Template pesan WhatsApp untuk absen pulang'
            ]
        ];

        $this->forge->addColumn('general_settings', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('general_settings', [
            'waha_api_url',
            'waha_api_key', 
            'waha_x_api_key',
            'wa_template_masuk',
            'wa_template_pulang'
        ]);
    }
}
