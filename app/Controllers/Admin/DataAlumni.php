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
            'graduation_years' => $this->siswaModel->getGraduationYears(),
            'userRole' => $userRole
        ];

        return view('admin/data/data-alumni', $data);
    }

    public function ambilDataAlumni()
    {
        $tahun_lulus = $this->request->getVar('tahun_lulus') ?? null;

        $result = $this->siswaModel->getAllAlumniByGraduationYear($tahun_lulus);

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
        
        // If reactivating alumni (changing from graduated to active), clear tahun_lulus
        if ($newStatus == 0) {
            $updateData['tahun_lulus'] = null;
        } else {
            // If graduating student, set current year as tahun_lulus
            $updateData['tahun_lulus'] = date('Y');
        }

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

    /**
     * View Student Data (Read-only)
     */
    public function viewSiswa($id_siswa)
    {
        // Check if user has access (superadmin or guru)
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if (!in_array($userRole, ['superadmin', 'guru'])) {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        // Get student data with class and department information
        $siswa = $this->siswaModel->getSiswaById($id_siswa);

        if (!$siswa) {
            throw new PageNotFoundException('Data siswa tidak ditemukan');
        }

        // Load NilaiModel to get student grades
        $nilaiModel = new \App\Models\NilaiModel();
        
        // Get all grades for this student with kelas information
        $allNilai = $nilaiModel->select('tb_nilai.*, tb_mapel.nama_mapel, tb_kelas.kelas')
                              ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
                              ->join('tb_kelas', 'tb_kelas.id_kelas = tb_nilai.id_kelas')
                              ->where('tb_nilai.id_siswa', $id_siswa)
                              ->orderBy('tb_nilai.tahun_ajaran', 'ASC')
                              ->orderBy('tb_nilai.semester', 'ASC')
                              ->orderBy('tb_kelas.kelas', 'ASC')
                              ->findAll();

        // Organize grades by academic year, kelas, and semester
        $nilaiByYear = [];
        foreach ($allNilai as $nilai) {
            $tahunAjaran = $nilai['tahun_ajaran'];
            $semester = $nilai['semester'];
            $kelas = $nilai['kelas'] ?: 'Tidak Diketahui';
            
            if (!isset($nilaiByYear[$tahunAjaran])) {
                $nilaiByYear[$tahunAjaran] = [];
            }
            
            if (!isset($nilaiByYear[$tahunAjaran][$kelas])) {
                $nilaiByYear[$tahunAjaran][$kelas] = [];
            }
            
            if (!isset($nilaiByYear[$tahunAjaran][$kelas][$semester])) {
                $nilaiByYear[$tahunAjaran][$kelas][$semester] = [];
            }
            
            $nilaiByYear[$tahunAjaran][$kelas][$semester][] = $nilai;
        }

        $data = [
            'title' => 'Lihat Data Siswa - ' . $siswa['nama_siswa'],
            'ctx' => 'alumni',
            'data' => $siswa,
            'nilaiByYear' => $nilaiByYear
        ];

        return view('admin/data/view/view-data-siswa', $data);
    }
}