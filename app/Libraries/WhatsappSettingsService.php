<?php

namespace App\Libraries;

use CodeIgniter\Database\ConnectionInterface;

class WhatsappSettingsService
{
    private $db;
    private $settings = null;

    public function __construct(ConnectionInterface $db = null)
    {
        $this->db = $db ?? \Config\Database::connect();
    }

    /**
     * Get WhatsApp settings from database
     * @return object|null
     */
    public function getSettings(): ?object
    {
        if ($this->settings === null) {
            $builder = $this->db->table('general_settings');
            $this->settings = $builder->select('waha_api_url, waha_api_key, waha_x_api_key, wa_template_masuk, wa_template_pulang, wa_template_guru_masuk, wa_template_guru_pulang')
                                    ->where('id', 1)
                                    ->get()
                                    ->getRow();
        }
        
        return $this->settings;
    }

    /**
     * Get WAHA API URL
     * @return string
     */
    public function getApiUrl(): string
    {
        $settings = $this->getSettings();
        return $settings->waha_api_url ?? env('WAHA_API_URL', 'http://localhost:3000');
    }

    /**
     * Get WAHA API Key
     * @return string
     */
    public function getApiKey(): string
    {
        $settings = $this->getSettings();
        return $settings->waha_api_key ?? env('WHATSAPP_TOKEN', '');
    }

    /**
     * Get WAHA X-API-Key
     * @return string
     */
    public function getXApiKey(): string
    {
        $settings = $this->getSettings();
        return $settings->waha_x_api_key ?? '';
    }

    /**
     * Get template for attendance in message
     * @param array $data - Array containing nama_siswa, tanggal, jam_masuk
     * @return string
     */
    public function getTemplateMasuk(array $data = []): string
    {
        $settings = $this->getSettings();
        $template = $settings->wa_template_masuk ?? 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.';
        
        return $this->replaceTemplateVariables($template, $data);
    }

    /**
     * Get template for attendance out message
     * @param array $data - Array containing nama_siswa, tanggal, jam_pulang
     * @return string
     */
    public function getTemplatePulang(array $data = []): string
    {
        $settings = $this->getSettings();
        $template = $settings->wa_template_pulang ?? 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.';
        
        return $this->replaceTemplateVariables($template, $data);
    }

    /**
     * Replace template variables with actual data
     * @param string $template
     * @param array $data
     * @return string
     */
    private function replaceTemplateVariables(string $template, array $data): string
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }
        
        return $template;
    }

    /**
     * Get template for teacher attendance in message
     * @param array $data - Array containing nama_guru, tanggal, jam_masuk
     * @return string
     */
    public function getTemplateGuruMasuk(array $data = []): string
    {
        $settings = $this->getSettings();
        $template = $settings->wa_template_guru_masuk ?? 'Halo {nama_guru}, Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.';
        
        return $this->replaceTemplateVariables($template, $data);
    }

    /**
     * Get template for teacher attendance out message
     * @param array $data - Array containing nama_guru, tanggal, jam_pulang
     * @return string
     */
    public function getTemplateGuruPulang(array $data = []): string
    {
        $settings = $this->getSettings();
        $template = $settings->wa_template_guru_pulang ?? 'Halo {nama_guru}, Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.';
        
        return $this->replaceTemplateVariables($template, $data);
    }

    /**
     * Check if WhatsApp notification is enabled
     * @return bool
     */
    public function isEnabled(): bool
    {
        return env('WA_NOTIFICATION', false) === 'true' || env('WA_NOTIFICATION', false) === true;
    }
}