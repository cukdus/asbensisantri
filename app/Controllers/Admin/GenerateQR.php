<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\UserModel;

class GenerateQR extends BaseController
{
    protected SiswaModel $siswaModel;
    protected KelasModel $kelasModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();

        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Check if user is superadmin
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if ($userRole !== 'superadmin') {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        $siswa = $this->siswaModel->getAllSiswaWithKelas();
        $kelas = $this->kelasModel->getDataKelas();
        $guru = $this->userModel->getAllGuru();

        $data = [
            'title' => 'Generate QR Code',
            'ctx' => 'qr',
            'siswa' => $siswa,
            'kelas' => $kelas,
            'guru' => $guru
        ];

        return view('admin/generate-qr/generate-qr', $data);
    }

    public function getSiswaByKelas()
    {
        $idKelas = $this->request->getVar('idKelas');

        $siswa = $this->siswaModel->getSiswaByKelas($idKelas);

        return $this->response->setJSON($siswa);
    }
}
