<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\UploadModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataSiswa extends BaseController
{
    protected SiswaModel $siswaModel;
    protected KelasModel $kelasModel;
    protected JurusanModel $jurusanModel;

    protected $siswaValidationRules = [
        'nama' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required' => 'Nama harus diisi'
            ]
        ],
        'id_kelas' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kelas harus diisi'
            ]
        ],
        'jk' => ['rules' => 'required', 'errors' => ['required' => 'Jenis kelamin wajib diisi']],
        'no_hp' => 'required|numeric|max_length[20]|min_length[5]',
        'nama_orang_tua' => [
            'rules' => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'Nama orang tua maksimal 255 karakter.'
            ]
        ],
        'alamat' => [
            'rules' => 'permit_empty|max_length[500]',
            'errors' => [
                'max_length' => 'Alamat maksimal 500 karakter.'
            ]
        ],
        'tahun_masuk' => [
            'rules' => 'permit_empty|numeric|exact_length[4]',
            'errors' => [
                'numeric' => 'Tahun masuk harus berupa angka.',
                'exact_length' => 'Tahun masuk harus 4 digit.'
            ]
        ],
        'foto' => [
            'rules' => 'permit_empty|uploaded[foto]|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
            'errors' => [
                'uploaded' => 'Pilih file foto terlebih dahulu.',
                'max_size' => 'Ukuran foto maksimal 2MB.',
                'is_image' => 'File yang dipilih harus berupa gambar.',
                'mime_in' => 'Format foto harus JPG, JPEG, PNG, atau GIF.'
            ]
        ]
    ];

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
            'title' => 'Data Siswa',
            'ctx' => 'siswa',
            'kelas' => $this->kelasModel->getDataKelas(),
            'jurusan' => $this->jurusanModel->getDataJurusan(),
            'userRole' => $userRole
        ];

        return view('admin/data/data-siswa', $data);
    }

    public function ambilDataSiswa()
    {
        $kelas = $this->request->getVar('kelas') ?? null;
        $jurusan = $this->request->getVar('jurusan') ?? null;

        $result = $this->siswaModel->getAllSiswaWithKelas($kelas, $jurusan);

        $data = [
            'data' => $result,
            'empty' => empty($result)
        ];

        return view('admin/data/list-data-siswa', $data);
    }

    public function formTambahSiswa()
    {
        $kelas = $this->kelasModel->getDataKelas();

        $data = [
            'ctx' => 'siswa',
            'kelas' => $kelas,
            'title' => 'Tambah Data Siswa'
        ];

        return view('admin/data/create/create-data-siswa', $data);
    }

    public function saveSiswa()
    {
        // validasi
        if (!$this->validate($this->siswaValidationRules)) {
            $kelas = $this->kelasModel->getDataKelas();

            $data = [
                'ctx' => 'siswa',
                'kelas' => $kelas,
                'title' => 'Tambah Data Siswa',
                'validation_errors' => $this->validator->getErrors(),
                'oldInput' => $this->request->getVar()
            ];
            return view('/admin/data/create/create-data-siswa', $data);
        }

        // handle foto upload
        $fotoName = null;
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // create uploads directory if not exists
            $uploadPath = FCPATH . 'uploads/siswa/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // generate unique filename
            $fotoName = $foto->getRandomName();

            // move file to uploads directory
            if (!$foto->move($uploadPath, $fotoName)) {
                session()->setFlashdata([
                    'msg' => 'Gagal mengupload foto',
                    'error' => true
                ]);
                return redirect()->to('/admin/siswa/create');
            }
        }

        // simpan (NIS akan di-generate otomatis)
        $result = $this->siswaModel->createSiswa(
            nama: $this->request->getVar('nama'),
            idKelas: intval($this->request->getVar('id_kelas')),
            jenisKelamin: $this->request->getVar('jk'),
            noHp: $this->request->getVar('no_hp'),
            tahunMasuk: $this->request->getVar('tahun_masuk'),
            foto: $fotoName,
            namaOrangTua: $this->request->getVar('nama_orang_tua'),
            alamat: $this->request->getVar('alamat')
        );

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Tambah data berhasil',
                'error' => false
            ]);
            return redirect()->to('/admin/siswa');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menambah data',
            'error' => true
        ]);
        return redirect()->to('/admin/siswa/create');
    }

    public function formEditSiswa($id)
    {
        $siswa = $this->siswaModel->getSiswaById($id);
        $kelas = $this->kelasModel->getDataKelas();

        if (empty($siswa) || empty($kelas)) {
            throw new PageNotFoundException('Data siswa dengan id ' . $id . ' tidak ditemukan');
        }

        $data = [
            'data' => $siswa,
            'kelas' => $kelas,
            'ctx' => 'siswa',
            'title' => 'Edit Siswa',
        ];

        return view('admin/data/edit/edit-data-siswa', $data);
    }

    public function updateSiswa()
    {
        $idSiswa = $this->request->getVar('id');

        $siswaLama = $this->siswaModel->getSiswaById($idSiswa);

        // validasi
        if (!$this->validate($this->siswaValidationRules)) {
            $siswa = $this->siswaModel->getSiswaById($idSiswa);
            $kelas = $this->kelasModel->getDataKelas();

            $data = [
                'data' => $siswa,
                'kelas' => $kelas,
                'ctx' => 'siswa',
                'title' => 'Edit Siswa',
                'validation_errors' => $this->validator->getErrors(),
                'oldInput' => $this->request->getVar()
            ];
            return view('/admin/data/edit/edit-data-siswa', $data);
        }

        // handle foto upload
        $fotoName = $siswaLama['foto'];  // Keep existing photo by default
        $foto = $this->request->getFile('foto');
        $removeFoto = $this->request->getVar('remove_foto');

        // Check if user wants to remove photo
        if ($removeFoto == '1') {
            // Delete old photo if exists
            if (!empty($siswaLama['foto'])) {
                $oldPhotoPath = FCPATH . 'uploads/siswa/' . $siswaLama['foto'];
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            $fotoName = null;
        } elseif ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // create uploads directory if not exists
            $uploadPath = FCPATH . 'uploads/siswa/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // generate unique filename
            $fotoName = $foto->getRandomName();

            // move file to uploads directory
            if ($foto->move($uploadPath, $fotoName)) {
                // delete old photo if exists
                if (!empty($siswaLama['foto'])) {
                    $oldPhotoPath = FCPATH . 'uploads/siswa/' . $siswaLama['foto'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
            } else {
                session()->setFlashdata([
                    'msg' => 'Gagal mengupload foto',
                    'error' => true
                ]);
                return redirect()->to('/admin/siswa/edit/' . $idSiswa);
            }
        }

        // update (NIS tidak diubah karena auto-generated)
        $result = $this->siswaModel->updateSiswa(
            id: $idSiswa,
            nama: $this->request->getVar('nama'),
            idKelas: intval($this->request->getVar('id_kelas')),
            jenisKelamin: $this->request->getVar('jk'),
            noHp: $this->request->getVar('no_hp'),
            foto: $fotoName,
            namaOrangTua: $this->request->getVar('nama_orang_tua'),
            alamat: $this->request->getVar('alamat'),
            tahunMasuk: $this->request->getVar('tahun_masuk')
        );

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Edit data berhasil',
                'error' => false
            ]);
            return redirect()->to('/admin/siswa');
        }

        session()->setFlashdata([
            'msg' => 'Gagal mengubah data',
            'error' => true
        ]);
        return redirect()->to('/admin/siswa/edit/' . $idSiswa);
    }

    public function delete($id)
    {
        $result = $this->siswaModel->delete($id);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data berhasil dihapus',
                'error' => false
            ]);
            return redirect()->to('/admin/siswa');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menghapus data',
            'error' => true
        ]);
        return redirect()->to('/admin/siswa');
    }

    /**
     * Delete Selected Posts
     */
    public function deleteSelectedSiswa()
    {
        $siswaIds = inputPost('siswa_ids');
        $this->siswaModel->deleteMultiSelected($siswaIds);
    }

    /**
     * Bulk Graduate Students
     */
    public function graduateSelectedSiswa()
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

        $siswaIds = $this->request->getPost('siswa_ids');
        
        if (empty($siswaIds) || !is_array($siswaIds)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Tidak ada siswa yang dipilih.'
            ]);
        }

        $updateData = [
            'is_graduated' => 1,
            'tahun_lulus' => date('Y')
        ];

        $successCount = 0;
        foreach ($siswaIds as $id) {
            if ($this->siswaModel->update($id, $updateData)) {
                $successCount++;
            }
        }

        if ($successCount > 0) {
            return $this->response->setJSON([
                'success' => true,
                'message' => "Berhasil meluluskan {$successCount} siswa."
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal meluluskan siswa.'
            ]);
        }
    }

    /*
     * -------------------------------------------------------------------------------------------------
     * IMPORT SISWA
     * -------------------------------------------------------------------------------------------------
     */

    /**
     * Bulk Post Upload
     */
    public function bulkPostSiswa()
    {
        $data['title'] = 'Import Siswa';
        $data['ctx'] = 'siswa';
        $data['kelas'] = $this->kelasModel->getDataKelas();

        return view('/admin/data/import-siswa', $data);
    }

    /**
     * Generate CSV Object Post
     */
    public function generateCSVObjectPost()
    {
        $uploadModel = new UploadModel();
        // delete old txt files
        $files = glob(FCPATH . 'uploads/tmp/*.txt');
        if (!empty($files)) {
            foreach ($files as $item) {
                @unlink($item);
            }
        }
        $file = $uploadModel->uploadCSVFile('file');
        if (!empty($file) && !empty($file['path'])) {
            $obj = $this->siswaModel->generateCSVObject($file['path']);
            if (!empty($obj)) {
                $data = [
                    'result' => 1,
                    'numberOfItems' => $obj->numberOfItems,
                    'txtFileName' => $obj->txtFileName,
                ];
                echo json_encode($data);
                exit();
            }
        }
        echo json_encode(['result' => 0]);
    }

    /**
     * Import CSV Item Post
     */
    public function importCSVItemPost()
    {
        $txtFileName = inputPost('txtFileName');
        $index = inputPost('index');
        $siswa = $this->siswaModel->importCSVItem($txtFileName, $index);
        if (!empty($siswa)) {
            $data = [
                'result' => 1,
                'siswa' => $siswa,
                'index' => $index
            ];
            echo json_encode($data);
        } else {
            $data = [
                'result' => 0,
                'index' => $index
            ];
            echo json_encode($data);
        }
    }

    /**
     * Download CSV File Post
     */
    public function downloadCSVFilePost()
    {
        $submit = inputPost('submit');
        $response = \Config\Services::response();
        if ($submit == 'csv_siswa_template') {
            return $response->download(FCPATH . 'assets/file/csv_siswa_template.csv', null);
        } elseif ($submit == 'csv_guru_template') {
            return $response->download(FCPATH . 'assets/file/csv_guru_template.csv', null);
        }
    }

    /**
     * Toggle Graduation Status
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

        // Toggle graduation status
        $newStatus = $siswa['is_graduated'] == 1 ? 0 : 1;
        
        $updateData = [
            'is_graduated' => $newStatus
        ];
        
        // If graduating the student, record the graduation year
        if ($newStatus == 1) {
            $updateData['tahun_lulus'] = date('Y');
        } else {
            // If un-graduating, clear the graduation year
            $updateData['tahun_lulus'] = null;
        }

        if ($this->siswaModel->update($id_siswa, $updateData)) {
            $statusText = $newStatus == 1 ? 'Lulus' : 'Belum Lulus';
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status kelulusan berhasil diubah menjadi: ' . $statusText,
                'new_status' => $newStatus,
                'status_text' => $statusText
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengubah status kelulusan.'
            ]);
        }
    }
}
