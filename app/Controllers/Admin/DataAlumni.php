<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataAlumni extends BaseController
{
    protected SiswaModel $siswaModel;
    protected KelasModel $kelasModel;
    protected JurusanModel $jurusanModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        // Check if user has access (superadmin or guru)
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if (!in_array($userRole, ['superadmin', 'guru'])) {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        $data = [
            'title' => 'Data Alumni',
            'ctx' => 'alumni',
            'kelas' => $this->kelasModel->getDataKelas(),
            'jurusan' => $this->jurusanModel->getDataJurusan(),
            'userRole' => $userRole
        ];

        return view('admin/data/data-alumni', $data);
    }

    public function ambilDataAlumni()
    {
        $kelas = $this->request->getVar('kelas') ?? null;
        $jurusan = $this->request->getVar('jurusan') ?? null;

        $result = $this->siswaModel->getAllAlumniWithKelas($kelas, $jurusan);

        $data = [
            'data' => $result,
            'empty' => empty($result)
        ];

        return view('admin/data/list-data-alumni', $data);
    }

    /**
     * Toggle Graduation Status (Reactivate Alumni)
     */
    public function toggleGraduationStatus()
    {
        // Check if user has access (superadmin or guru)
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if (!in_array($userRole, ['superadmin', 'guru'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk melakukan aksi ini.'
            ]);
        }

        $id_siswa = $this->request->getPost('id_siswa');
        
        if (!$id_siswa) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID siswa tidak valid.'
            ]);
        }

        // Get current student data
        $siswa = $this->siswaModel->find($id_siswa);
        
        if (!$siswa) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan.'
            ]);
        }

        // Toggle graduation status (reactivate alumni back to active student)
        $newStatus = $siswa['is_graduated'] == 1 ? 0 : 1;
        
        $updateData = [
            'is_graduated' => $newStatus
        ];

        if ($this->siswaModel->update($id_siswa, $updateData)) {
            $statusText = $newStatus == 1 ? 'Lulus' : 'Aktif';
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status kelulusan berhasil diubah menjadi: ' . $statusText,
                'new_status' => $newStatus,
                'status_text' => $statusText
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengubah status kelulusan.'
        ]);
    }
}