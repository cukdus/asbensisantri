<?php

namespace App\Controllers;

use App\Libraries\enums\TipeUser;
use App\Libraries\WhatsappSettingsService;
use App\Models\GuruModel;
use App\Models\PresensiGuruModel;
use App\Models\PresensiSiswaModel;
use App\Models\SiswaModel;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Scan extends BaseController
{
    private bool $WANotificationEnabled;
    private WhatsappSettingsService $whatsappService;

    protected SiswaModel $siswaModel;
    protected UserModel $userModel;
    protected PresensiSiswaModel $presensiSiswaModel;
    protected PresensiGuruModel $presensiGuruModel;

    public function __construct()
    {
        $this->WANotificationEnabled = getenv('WA_NOTIFICATION') === 'true' ? true : false;
        $this->whatsappService = new WhatsappSettingsService();

        $this->siswaModel = new SiswaModel();
        $this->userModel = new UserModel();
        $this->presensiSiswaModel = new PresensiSiswaModel();
        $this->presensiGuruModel = new PresensiGuruModel();
    }

    public function index($t = 'Masuk')
    {
        $data = ['waktu' => $t, 'title' => 'Absensi Siswa dan Guru Berbasis QR Code'];
        return view('scan/scan', $data);
    }

    public function cekKode()
    {
        // ambil variabel POST
        $uniqueCode = $this->request->getVar('unique_code');
        $waktuAbsen = $this->request->getVar('waktu');

        $status = false;
        $type = TipeUser::Siswa;

        // cek data siswa di database
        $result = $this->siswaModel->cekSiswa($uniqueCode);

        if (empty($result)) {
            // jika cek siswa gagal, cek data guru
            $result = $this->userModel->cekGuru($uniqueCode);

            if (!empty($result)) {
                $status = true;

                $type = TipeUser::Guru;
            } else {
                $status = false;

                $result = NULL;
            }
        } else {
            $status = true;
        }

        if (!$status) {  // data tidak ditemukan
            return $this->showErrorView('Data tidak ditemukan');
        }

        // jika data ditemukan
        switch ($waktuAbsen) {
            case 'masuk':
                return $this->absenMasuk($type, $result);
                break;

            case 'pulang':
                return $this->absenPulang($type, $result);
                break;

            default:
                return $this->showErrorView('Data tidak valid');
                break;
        }
    }

    public function absenMasuk($type, $result)
    {
        // data ditemukan
        $data['data'] = $result;
        $data['waktu'] = 'masuk';

        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        $messageString = " sudah absen masuk pada tanggal $date jam $time";
        // absen masuk
        switch ($type) {
            case TipeUser::Guru:
                $idGuru = $result['id_guru'];
                $data['type'] = TipeUser::Guru;

                $sudahAbsen = $this->presensiGuruModel->cekAbsen($idGuru, $date);

                if ($sudahAbsen) {
                    // Extract id_presensi from the array returned by cekAbsen
                    $idPresensi = $sudahAbsen['id_presensi'];
                    $data['presensi'] = $this->presensiGuruModel->getPresensiById($idPresensi);
                    return $this->showErrorView('Anda sudah absen hari ini', $data);
                }

                try {
                    $this->presensiGuruModel->absenMasuk($idGuru, $date, $time);
                    $data['presensi'] = $this->presensiGuruModel->getPresensiByIdGuruTanggal($idGuru, $date);

                    // Prepare WhatsApp message using template from database
                    if ($this->WANotificationEnabled && !empty($result['no_hp'])) {
                        $templateData = [
                            'nama_guru' => $result['nama_guru'],
                            'tanggal' => date('d/m/Y', strtotime($date)),
                            'jam_masuk' => $time
                        ];
                        $messageString = $this->whatsappService->getTemplateGuruMasuk($templateData);

                        $message = [
                            'destination' => $result['no_hp'],
                            'message' => $messageString,
                            'delay' => 0
                        ];
                        try {
                            $this->sendNotification($message);
                        } catch (\Exception $e) {
                            log_message('error', 'Error sending notification: ' . $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Error saat absen masuk guru: ' . $e->getMessage());
                    return $this->showErrorView('Terjadi kesalahan saat mencatat presensi', $data);
                }

                break;

            case TipeUser::Siswa:
                $idSiswa = $result['id_siswa'];
                $idKelas = $result['id_kelas'];
                $data['type'] = TipeUser::Siswa;

                $sudahAbsen = $this->presensiSiswaModel->cekAbsen($idSiswa, Time::today()->toDateString());

                if ($sudahAbsen) {
                    $data['presensi'] = $this->presensiSiswaModel->getPresensiById($sudahAbsen);
                    return $this->showErrorView('Anda sudah absen hari ini', $data);
                }

                $this->presensiSiswaModel->absenMasuk($idSiswa, $date, $time, $idKelas);
                $data['presensi'] = $this->presensiSiswaModel->getPresensiByIdSiswaTanggal($idSiswa, $date);

                // Prepare WhatsApp message using template from database
                if ($this->WANotificationEnabled && !empty($result['no_hp'])) {
                    $templateData = [
                        'nama_siswa' => $result['nama_siswa'],
                        'tanggal' => date('d/m/Y', strtotime($date)),
                        'jam_masuk' => $time
                    ];
                    $messageString = $this->whatsappService->getTemplateMasuk($templateData);

                    $message = [
                        'destination' => $result['no_hp'],
                        'message' => $messageString,
                        'delay' => 0
                    ];
                    try {
                        $this->sendNotification($message);
                    } catch (\Exception $e) {
                        log_message('error', 'Error sending notification: ' . $e->getMessage());
                    }
                }

                break;

            default:
                return $this->showErrorView('Tipe tidak valid');
        }
        return view('scan/scan-result', $data);
    }

    public function absenPulang($type, $result)
    {
        // data ditemukan
        $data['data'] = $result;
        $data['waktu'] = 'pulang';

        $date = Time::today()->toDateString();
        $time = Time::now()->toTimeString();
        $messageString = " sudah absen pulang pada tanggal $date jam $time";
        $sendWhatsApp = false;  // Flag untuk menentukan apakah perlu kirim WhatsApp

        // absen pulang
        switch ($type) {
            case TipeUser::Guru:
                $idGuru = $result['id_guru'];
                $data['type'] = TipeUser::Guru;

                $sudahAbsen = $this->presensiGuruModel->cekAbsen($idGuru, $date);

                if (!$sudahAbsen) {
                    return $this->showErrorView('Anda belum absen hari ini', $data);
                }

                // Extract id_presensi from the array returned by cekAbsen
                $idPresensi = $sudahAbsen['id_presensi'];

                // Cek apakah sudah absen pulang
                $presensiData = $this->presensiGuruModel->getPresensiById($idPresensi);
                if (!empty($presensiData['jam_keluar'])) {
                    $data['presensi'] = $presensiData;
                    return $this->showErrorView('Anda sudah absen pulang hari ini', $data);
                }

                try {
                    $this->presensiGuruModel->absenKeluar($idPresensi, $time);
                    $data['presensi'] = $this->presensiGuruModel->getPresensiById($idPresensi);

                    // Prepare WhatsApp message using template from database
                    if ($this->WANotificationEnabled && !empty($result['no_hp'])) {
                        $templateData = [
                            'nama_guru' => $result['nama_guru'],
                            'tanggal' => date('d/m/Y', strtotime($date)),
                            'jam_pulang' => $time
                        ];
                        $messageString = $this->whatsappService->getTemplateGuruPulang($templateData);

                        $message = [
                            'destination' => $result['no_hp'],
                            'message' => $messageString,
                            'delay' => 0
                        ];
                        try {
                            $this->sendNotification($message);
                        } catch (\Exception $e) {
                            log_message('error', 'Error sending notification: ' . $e->getMessage());
                        }
                    }
                } catch (\Exception $e) {
                    log_message('error', 'Error saat absen pulang guru: ' . $e->getMessage());
                    return $this->showErrorView('Terjadi kesalahan saat mencatat presensi pulang', $data);
                }

                break;

            case TipeUser::Siswa:
                $idSiswa = $result['id_siswa'];
                $data['type'] = TipeUser::Siswa;

                $sudahAbsen = $this->presensiSiswaModel->cekAbsen($idSiswa, $date);

                if (!$sudahAbsen) {
                    return $this->showErrorView('Anda belum absen hari ini', $data);
                }

                // Cek apakah sudah absen pulang
                $presensiData = $this->presensiSiswaModel->getPresensiById($sudahAbsen);
                if (!empty($presensiData['jam_keluar'])) {
                    $data['presensi'] = $presensiData;
                    return $this->showErrorView('Anda sudah absen pulang hari ini', $data);
                }

                $this->presensiSiswaModel->absenKeluar($sudahAbsen, $time);
                $data['presensi'] = $this->presensiSiswaModel->getPresensiById($sudahAbsen);

                // Prepare WhatsApp message using template from database
                if ($this->WANotificationEnabled && !empty($result['no_hp'])) {
                    $templateData = [
                        'nama_siswa' => $result['nama_siswa'],
                        'tanggal' => date('d/m/Y', strtotime($date)),
                        'jam_pulang' => $time
                    ];
                    $messageString = $this->whatsappService->getTemplatePulang($templateData);

                    $message = [
                        'destination' => $result['no_hp'],
                        'message' => $messageString,
                        'delay' => 0
                    ];
                    try {
                        $this->sendNotification($message);
                    } catch (\Exception $e) {
                        log_message('error', 'Error sending notification: ' . $e->getMessage());
                    }
                }

                break;
            default:
                return $this->showErrorView('Tipe tidak valid');
        }

        return view('scan/scan-result', $data);
    }

    public function showErrorView(string $msg = 'no error message', $data = NULL)
    {
        $errdata = $data ?? [];
        $errdata['msg'] = $msg;

        return view('scan/error-scan-result', $errdata);
    }

    protected function sendNotification($message)
    {
        $provider = getenv('WHATSAPP_PROVIDER');

        if (empty($provider)) {
            return;
        }

        switch ($provider) {
            case 'Waha':
                $whatsapp = new \App\Libraries\Whatsapp\Waha\Waha;
                break;
            default:
                return;
        }
        $whatsapp->sendMessage($message);
    }
}
