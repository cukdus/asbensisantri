<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataNilai extends BaseController
{
    protected NilaiModel $nilaiModel;
    protected UserModel $userModel;
    protected MapelModel $mapelModel;
    protected SiswaModel $siswaModel;
    protected KelasModel $kelasModel;

    public function __construct()
    {
        $this->nilaiModel = new NilaiModel();
        $this->userModel = new UserModel();
        $this->mapelModel = new MapelModel();
        $this->siswaModel = new SiswaModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Nilai Siswa',
            'ctx' => 'nilai',
            'mapel' => $this->mapelModel->getAllMapel(),
            'siswa' => $this->siswaModel->findAll()
        ];

        return view('admin/data/data-nilai', $data);
    }

    public function ambilDataNilai()
    {
        $mapelId = $this->request->getGet('mapel_id');
        $siswaId = $this->request->getGet('siswa_id');
        $semester = $this->request->getGet('semester');
        $tahunAjaran = $this->request->getGet('tahun_ajaran');

        $filters = [];
        if ($mapelId)
            $filters['id_mapel'] = $mapelId;
        if ($siswaId)
            $filters['id_siswa'] = $siswaId;
        if ($semester)
            $filters['semester'] = $semester;
        if ($tahunAjaran)
            $filters['tahun_ajaran'] = $tahunAjaran;

        $result = $this->nilaiModel->getNilaiWithFilters($filters);

        $data = [
            'data' => $result,
            'empty' => empty($result)
        ];

        return view('admin/data/list-data-nilai', $data);
    }

    public function formTambahNilai()
    {
        $data = [
            'title' => 'Tambah Nilai Siswa',
            'ctx' => 'nilai',
            'mapelList' => $this->mapelModel->getAllMapel(),
            'siswaList' => $this->siswaModel->findAll()
        ];

        return view('admin/data/create/create-data-nilai', $data);
    }

    public function saveNilai()
    {
        $validation = \Config\Services::validation();

        // Basic validation rules
        $rules = [
            'id_siswa' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Siswa harus dipilih',
                    'integer' => 'Siswa harus dipilih dengan benar'
                ]
            ],
            'semester' => [
                'rules' => 'required|in_list[1,2]',
                'errors' => [
                    'required' => 'Semester harus dipilih',
                    'in_list' => 'Semester harus 1 atau 2'
                ]
            ],
            'tahun_ajaran' => [
                'rules' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
                'errors' => [
                    'required' => 'Tahun ajaran harus diisi',
                    'regex_match' => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025)'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata([
                'msg' => 'Data tidak valid',
                'error' => true
            ]);
            return redirect()->back()->withInput();
        }

        $idSiswa = $this->request->getPost('id_siswa');
        $semester = $this->request->getPost('semester');
        $tahunAjaran = $this->request->getPost('tahun_ajaran');
        $mapelData = $this->request->getPost('mapel');

        // Check if we have old format (single subject) or new format (multiple subjects)
        if ($this->request->getPost('id_mapel') && $this->request->getPost('nilai')) {
            // Old format - single subject
            $idMapel = $this->request->getPost('id_mapel');
            $nilai = $this->request->getPost('nilai');
            $keterangan = $this->request->getPost('keterangan') ?: '';

            // Check if nilai already exists for this combination
            if ($this->nilaiModel->isNilaiExists($idSiswa, $idMapel, $semester, $tahunAjaran)) {
                session()->setFlashdata([
                    'msg' => 'Nilai untuk siswa, mata pelajaran, semester, dan tahun ajaran tersebut sudah ada',
                    'error' => true
                ]);
                return redirect()->back()->withInput();
            }

            $data = [
                'id_siswa' => $idSiswa,
                'id_mapel' => $idMapel,
                'nilai' => $nilai,
                'semester' => $semester,
                'tahun_ajaran' => $tahunAjaran,
                'keterangan' => $keterangan
            ];

            $result = $this->nilaiModel->createNilai($data);

            if ($result) {
                session()->setFlashdata([
                    'msg' => 'Data nilai berhasil ditambahkan',
                    'error' => false
                ]);
                return redirect()->to('/admin/nilai');
            }
        } else if ($mapelData && is_array($mapelData)) {
            // New format - multiple subjects
            $successCount = 0;
            $errorCount = 0;
            $duplicateCount = 0;
            $errors = [];

            foreach ($mapelData as $index => $mapel) {
                // Skip if nilai is empty
                if (empty($mapel['nilai']) || trim($mapel['nilai']) === '') {
                    continue;
                }

                // Validate nilai
                if (!is_numeric($mapel['nilai']) || $mapel['nilai'] < 0 || $mapel['nilai'] > 100) {
                    $errors[] = "Nilai untuk mata pelajaran {$mapel['nama_mapel']} harus antara 0-100";
                    $errorCount++;
                    continue;
                }

                // Check if nilai already exists for this combination
                if ($this->nilaiModel->isNilaiExists($idSiswa, $mapel['id_mapel'], $semester, $tahunAjaran)) {
                    $duplicateCount++;
                    continue;
                }

                $data = [
                    'id_siswa' => $idSiswa,
                    'id_mapel' => $mapel['id_mapel'],
                    'nilai' => $mapel['nilai'],
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'keterangan' => $mapel['keterangan'] ?: ''
                ];

                if ($this->nilaiModel->createNilai($data)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $errors[] = "Gagal menyimpan nilai untuk mata pelajaran {$mapel['nama_mapel']}";
                }
            }

            // Prepare response message
            $messages = [];
            if ($successCount > 0) {
                $messages[] = "{$successCount} nilai berhasil ditambahkan";
            }
            if ($duplicateCount > 0) {
                $messages[] = "{$duplicateCount} nilai sudah ada sebelumnya";
            }
            if ($errorCount > 0) {
                $messages[] = "{$errorCount} nilai gagal ditambahkan";
            }

            $message = implode(', ', $messages);
            $isError = $successCount === 0;

            if (!empty($errors)) {
                $message .= '. Error: ' . implode(', ', $errors);
            }

            session()->setFlashdata([
                'msg' => $message,
                'error' => $isError
            ]);

            if ($successCount > 0) {
                return redirect()->to('/admin/nilai');
            } else {
                return redirect()->back()->withInput();
            }
        } else {
            session()->setFlashdata([
                'msg' => 'Tidak ada nilai yang diisi',
                'error' => true
            ]);
            return redirect()->back()->withInput();
        }

        session()->setFlashdata([
            'msg' => 'Gagal menambahkan data nilai',
            'error' => true
        ]);
        return redirect()->back()->withInput();
    }

    public function formEditNilai($id)
    {
        $nilai = $this->nilaiModel->getNilaiById($id);

        if (!$nilai) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nilai tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Nilai Siswa',
            'ctx' => 'nilai',
            'nilai' => $nilai,
            'mapelList' => $this->mapelModel->getAllMapel(),
            'siswaList' => $this->siswaModel->findAll()
        ];

        return view('admin/data/edit/edit-data-nilai', $data);
    }

    public function updateNilai()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'id_nilai' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'ID nilai harus ada',
                    'integer' => 'ID nilai tidak valid'
                ]
            ],
            'id_siswa' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Siswa harus dipilih',
                    'integer' => 'Siswa harus dipilih dengan benar'
                ]
            ],
            'id_mapel' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Mata pelajaran harus dipilih',
                    'integer' => 'Mata pelajaran harus dipilih dengan benar'
                ]
            ],
            'nilai' => [
                'rules' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
                'errors' => [
                    'required' => 'Nilai harus diisi',
                    'decimal' => 'Nilai harus berupa angka',
                    'greater_than_equal_to' => 'Nilai minimal 0',
                    'less_than_equal_to' => 'Nilai maksimal 100'
                ]
            ],
            'semester' => [
                'rules' => 'required|in_list[1,2]',
                'errors' => [
                    'required' => 'Semester harus dipilih',
                    'in_list' => 'Semester harus 1 atau 2'
                ]
            ],
            'tahun_ajaran' => [
                'rules' => 'required|regex_match[/^\d{4}\/\d{4}$/]',
                'errors' => [
                    'required' => 'Tahun ajaran harus diisi',
                    'regex_match' => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025)'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata([
                'msg' => 'Data tidak valid',
                'error' => true
            ]);
            return redirect()->back()->withInput();
        }

        $id = $this->request->getPost('id_nilai');
        $idSiswa = $this->request->getPost('id_siswa');
        $idMapel = $this->request->getPost('id_mapel');
        $semester = $this->request->getPost('semester');
        $tahunAjaran = $this->request->getPost('tahun_ajaran');

        // Check if nilai already exists for this combination (excluding current record)
        if ($this->nilaiModel->isNilaiExists($idSiswa, $idMapel, $semester, $tahunAjaran, $id)) {
            session()->setFlashdata([
                'msg' => 'Nilai untuk siswa, mata pelajaran, semester, dan tahun ajaran tersebut sudah ada',
                'error' => true
            ]);
            return redirect()->back()->withInput();
        }

        $data = [
            'id_siswa' => $idSiswa,
            'id_mapel' => $idMapel,
            'nilai' => $this->request->getPost('nilai'),
            'semester' => $semester,
            'tahun_ajaran' => $tahunAjaran
        ];

        $result = $this->nilaiModel->updateNilai($id, $data);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data nilai berhasil diperbarui',
                'error' => false
            ]);
            return redirect()->to('/admin/nilai');
        }

        session()->setFlashdata([
            'msg' => 'Gagal memperbarui data nilai',
            'error' => true
        ]);
        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $result = $this->nilaiModel->deleteNilai($id);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data nilai berhasil dihapus',
                'error' => false
            ]);
            return redirect()->to('/admin/nilai');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menghapus data nilai',
            'error' => true
        ]);
        return redirect()->to('/admin/nilai');
    }

    public function statistik()
    {
        $stats = $this->nilaiModel->getGradeStatistics();

        $data = [
            'title' => 'Statistik Nilai Siswa',
            'ctx' => 'nilai',
            'stats' => $stats
        ];

        return view('admin/data/statistik-nilai', $data);
    }

    public function siswaByKelas($id_kelas)
    {
        // Get kelas information
        $kelas = $this->kelasModel->getKelas($id_kelas);
        if (empty($kelas)) {
            throw new PageNotFoundException('Kelas tidak ditemukan');
        }

        // Get students in this class
        $siswaList = $this->siswaModel->getSiswaByKelas($id_kelas);

        $data = [
            'title' => 'Data Nilai Siswa - ' . $kelas->kelas . ' ' . $kelas->jurusan,
            'ctx' => 'nilai',
            'kelas' => $kelas,
            'siswaList' => $siswaList,
            'empty' => empty($siswaList)
        ];

        return view('admin/data/siswa-by-kelas-nilai', $data);
    }

    public function formTambahNilaiSiswa($id_siswa)
    {
        // Get student information
        $siswa = $this->siswaModel->getSiswaById($id_siswa);
        if (empty($siswa)) {
            throw new PageNotFoundException('Siswa tidak ditemukan');
        }

        // Get subjects filtered by student's class
        $mapelList = $this->mapelModel->getMapelByKelasId($siswa['id_kelas']);
        
        // If no subjects found for this class, get all subjects as fallback
        if (empty($mapelList)) {
            $mapelList = $this->mapelModel->getAllMapel();
        }

        $data = [
            'title' => 'Tambah Nilai - ' . $siswa['nama_siswa'],
            'ctx' => 'nilai',
            'siswa' => $siswa,
            'mapelList' => $mapelList
        ];

        return view('admin/data/create/create-nilai-siswa', $data);
    }

    public function lihatNilaiSiswa($id_siswa)
    {
        // Get student information
        $siswa = $this->siswaModel->getSiswaById($id_siswa);
        if (empty($siswa)) {
            throw new PageNotFoundException('Siswa tidak ditemukan');
        }

        // Get all grades for this student
        $nilaiList = $this->nilaiModel->getNilaiBySiswaId($id_siswa);

        $data = [
            'title' => 'Lihat Nilai - ' . $siswa['nama_siswa'],
            'ctx' => 'nilai',
            'siswa' => $siswa,
            'nilaiList' => $nilaiList
        ];

        return view('admin/data/view/view-nilai-siswa', $data);
    }
}
