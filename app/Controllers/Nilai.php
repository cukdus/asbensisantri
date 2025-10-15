<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\MapelModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Nilai extends BaseController
{
    protected $siswaModel;
    protected $nilaiModel;
    protected $mapelModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
        $this->nilaiModel = new NilaiModel();
        $this->mapelModel = new MapelModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Cek Nilai Siswa',
            'validation' => \Config\Services::validation()
        ];

        return view('nilai/index', $data);
    }

    public function cekNilai()
    {
        // Validasi input
        $rules = [
            'nis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIS harus diisi'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/nilai')->withInput()->with('errors', $this->validator->getErrors());
        }

        $nis = $this->request->getPost('nis');

        // Cari siswa berdasarkan NIS
        $siswa = $this->siswaModel->where('nis', $nis)->first();

        if (empty($siswa)) {
            return redirect()->to('/nilai')->with('error', 'Siswa dengan NIS tersebut tidak ditemukan');
        }

        // Pastikan id_siswa tersedia
        $id_siswa = $siswa['id_siswa'];

        if (empty($id_siswa)) {
            return redirect()->to('/nilai')->with('error', 'Data siswa tidak lengkap');
        }

        // Ambil nilai siswa berdasarkan id_siswa
        $nilaiList = $this
            ->nilaiModel
            ->select('tb_nilai.*, tb_mapel.nama_mapel, tb_kelas.kelas')
            ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_nilai.id_kelas')
            ->where('tb_nilai.id_siswa', $id_siswa)
            ->orderBy('tb_nilai.tahun_ajaran', 'DESC')
            ->orderBy('tb_nilai.semester', 'ASC')
            ->orderBy('tb_kelas.kelas', 'ASC')
            ->findAll();

        // Kelompokkan nilai berdasarkan semester
        // Mendukung format angka (1/2) dan string ('Ganjil'/'Genap')
        $semesterGanjil = array_filter($nilaiList, function ($item) {
            return $item['semester'] == 1 || $item['semester'] === 'Ganjil';
        });

        $semesterGenap = array_filter($nilaiList, function ($item) {
            return $item['semester'] == 2 || $item['semester'] === 'Genap';
        });

        $data = [
            'title' => 'Nilai Siswa - ' . $siswa['nama_siswa'],
            'siswa' => $siswa,
            'nilaiList' => $nilaiList,
            'semesterGanjil' => $semesterGanjil,
            'semesterGenap' => $semesterGenap
        ];

        return view('nilai/hasil', $data);
    }
}
