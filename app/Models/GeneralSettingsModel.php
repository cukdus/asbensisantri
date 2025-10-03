<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneralSettingsModel extends BaseModel
{
   protected $builder;

   public function __construct()
   {
      parent::__construct();
      $this->builder = $this->db->table('general_settings');
   }

   //input values
   public function inputValues()
   {
      return [
         'school_name' => inputPost('school_name'),
         'school_year' => inputPost('school_year'),
         'copyright' => inputPost('copyright'),
      ];
   }

   //input values for WhatsApp settings
   public function inputWhatsAppValues()
   {
      return [
         'waha_api_url' => inputPost('waha_api_url'),
         'waha_api_key' => inputPost('waha_api_key'),
         'waha_x_api_key' => inputPost('waha_x_api_key'),
         'wa_template_masuk' => inputPost('wa_template_masuk'),
         'wa_template_pulang' => inputPost('wa_template_pulang'),
         'wa_template_guru_masuk' => inputPost('wa_template_guru_masuk'),
         'wa_template_guru_pulang' => inputPost('wa_template_guru_pulang'),
      ];
   }

   public function updateSettings()
   {
      $data = $this->inputValues();

      $uploadModel = new UploadModel();
      $logoPath = $uploadModel->uploadLogo('logo');

      if (!empty($logoPath) && !empty($logoPath['path'])) {
         $oldLogo = $this->generalSettings->logo;
         $data['logo'] = $logoPath['path'];
         if (file_exists($oldLogo)) {
            @unlink($oldLogo);
        }
      }

      return $this->builder->where('id', 1)->update($data);
   }

   public function updateWhatsAppSettings()
   {
      $data = $this->inputWhatsAppValues();
      return $this->builder->where('id', 1)->update($data);
   }
}
