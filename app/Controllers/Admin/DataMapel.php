<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\JurusanModel;
use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DataMapel extends BaseController
{
    protected MapelModel $mapelModel;
    protected UserModel $userModel;
    protected GuruModel $guruModel;
    protected KelasModel $kelasModel;
    protected JurusanModel $jurusanModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
        $this->userModel = new UserModel();
        $this->guruModel = new GuruModel();
        $this->kelasModel = new KelasModel();
        $this->jurusanModel = new JurusanModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Mata Pelajaran',
            'ctx' => 'mapel',
            'kelas' => $this->kelasModel->getDataKelas(),
            'jurusan' => $this->jurusanModel->getDataJurusan()
        ];

        return view('admin/data/data-mapel', $data);
    }

    public function ambilDataMapel()
    {
        $kelasId = $this->request->getVar('kelasId') ?? null;

        if ($kelasId) {
            $result = $this->mapelModel->getMapelByKelasId($kelasId);
        } else {
            $result = $this->mapelModel->getAllMapel();
        }

        $data = [
            'data' => $result,
            'empty' => empty($result)
        ];

        return view('admin/data/list-data-mapel', $data);
    }

    /**
     * Get mapel by kelas for sub-menu functionality
     */
    public function mapelByKelas($kelasId)
    {
        $kelas = $this->kelasModel->getKelas($kelasId);
        if (!$kelas) {
            throw new PageNotFoundException('Kelas tidak ditemukan');
        }

        $data = [
            'title' => 'Mata Pelajaran - ' . $kelas->kelas . ' ' . $kelas->jurusan,
            'ctx' => 'mapel',
            'kelas' => $kelas,
            'kelasId' => $kelasId
        ];

        return view('admin/data/mapel-by-kelas', $data);
    }

    public function formTambahMapel()
    {
        $data = [
            'title' => 'Tambah Mata Pelajaran',
            'ctx' => 'mapel',
            'guru' => $this->userModel->getDataGuru(),
            'kelas' => $this->kelasModel->getDataKelas()
        ];

        return view('admin/data/create/create-data-mapel', $data);
    }

    public function saveMapel()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama_mapel' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama mata pelajaran harus diisi',
                    'min_length' => 'Nama mata pelajaran minimal 3 karakter',
                    'max_length' => 'Nama mata pelajaran maksimal 100 karakter'
                ]
            ],
            'user_id' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Guru harus dipilih dengan benar'
                ]
            ],
            'id_kelas' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Kelas harus dipilih dengan benar'
                ]
            ],
            'id_kelas' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Kelas harus dipilih dengan benar'
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

        $namaMapel = $this->request->getPost('nama_mapel');

        // Check if mata pelajaran already exists
        if ($this->mapelModel->isMapelExists($namaMapel)) {
            session()->setFlashdata([
                'msg' => 'Mata pelajaran dengan nama tersebut sudah ada',
                'error' => true
            ]);
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_mapel' => $namaMapel,
            'user_id' => $this->request->getPost('user_id') ?: null,
            'id_guru' => $this->request->getPost('user_id') ?: null,
            'id_kelas' => $this->request->getPost('id_kelas') ?: null
        ];

        $result = $this->mapelModel->createMapel($data);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data mata pelajaran berhasil ditambahkan',
                'error' => false
            ]);
            return redirect()->to('/admin/mapel');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menambahkan data mata pelajaran',
            'error' => true
        ]);
        return redirect()->back()->withInput();
    }

    public function formEditMapel($id)
    {
        $mapel = $this->mapelModel->getMapelById($id);

        if (!$mapel) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Mata pelajaran tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Mata Pelajaran',
            'ctx' => 'mapel',
            'mapel' => $mapel,
            'guru' => $this->userModel->getDataGuru(),
            'kelas' => $this->kelasModel->getDataKelas()
        ];

        return view('admin/data/edit/edit-data-mapel', $data);
    }

    public function updateMapel()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'id_mapel' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'ID mata pelajaran harus ada',
                    'integer' => 'ID mata pelajaran tidak valid'
                ]
            ],
            'nama_mapel' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama mata pelajaran harus diisi',
                    'min_length' => 'Nama mata pelajaran minimal 3 karakter',
                    'max_length' => 'Nama mata pelajaran maksimal 100 karakter'
                ]
            ],
            'user_id' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Guru harus dipilih dengan benar'
                ]
            ],
            'id_kelas' => [
                'rules' => 'permit_empty|integer',
                'errors' => [
                    'integer' => 'Kelas harus dipilih dengan benar'
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

        $id = $this->request->getPost('id_mapel');
        $namaMapel = $this->request->getPost('nama_mapel');

        // Check if mata pelajaran already exists (excluding current record)
        if ($this->mapelModel->isMapelExists($namaMapel, $id)) {
            session()->setFlashdata([
                'msg' => 'Mata pelajaran dengan nama tersebut sudah ada',
                'error' => true
            ]);
            return redirect()->back()->withInput();
        }

        $data = [
            'nama_mapel' => $namaMapel,
            'user_id' => $this->request->getPost('user_id') ?: null,
            'id_guru' => $this->request->getPost('user_id') ?: null,
            'id_kelas' => $this->request->getPost('id_kelas') ?: null
        ];

        $result = $this->mapelModel->updateMapel($id, $data);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data mata pelajaran berhasil diperbarui',
                'error' => false
            ]);
            return redirect()->to('/admin/mapel');
        }

        session()->setFlashdata([
            'msg' => 'Gagal memperbarui data mata pelajaran',
            'error' => true
        ]);
        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $result = $this->mapelModel->deleteMapel($id);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data mata pelajaran berhasil dihapus',
                'error' => false
            ]);
            return redirect()->to('/admin/mapel');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menghapus data mata pelajaran',
            'error' => true
        ]);
        return redirect()->to('/admin/mapel');
    }
}
