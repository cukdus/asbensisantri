<?php

namespace App\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $table = 'tb_mapel';
    protected $primaryKey = 'id_mapel';
    protected $allowedFields = ['nama_mapel', 'user_id', 'id_guru', 'id_kelas'];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    /**
     * Get all mata pelajaran with kelas and guru information
     */
    public function getAllMapel()
    {
        return $this->select('tb_mapel.*, users.nama_lengkap as nama_guru, tb_kelas.kelas, tb_jurusan.jurusan')
                    ->join('users', 'users.id = tb_mapel.user_id', 'left')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_mapel.id_kelas', 'left')
                    ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan', 'left')
                    ->findAll();
    }

    /**
     * Get mata pelajaran by kelas ID (includes subjects for specific class and subjects for all classes)
     */
    public function getMapelByKelasId($kelasId)
    {
        return $this->select('tb_mapel.*, users.nama_lengkap as nama_guru, tb_kelas.kelas, tb_jurusan.jurusan')
                    ->join('users', 'users.id = tb_mapel.user_id', 'left')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_mapel.id_kelas', 'left')
                    ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan', 'left')
                    ->groupStart()
                        ->where('tb_mapel.id_kelas', $kelasId)
                        ->orWhere('tb_mapel.id_kelas IS NULL')
                    ->groupEnd()
                    ->orderBy('tb_mapel.nama_mapel')
                    ->findAll();
    }

    /**
     * Get mata pelajaran grouped by kelas
     */
    public function getMapelGroupedByKelas()
    {
        return $this->select('tb_mapel.*, users.nama_lengkap as nama_guru, tb_kelas.kelas, tb_kelas.id_kelas, tb_jurusan.jurusan, tb_jurusan.id as id_jurusan')
                    ->join('users', 'users.id = tb_mapel.user_id', 'left')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_mapel.id_kelas', 'left')
                    ->join('tb_jurusan', 'tb_jurusan.id = tb_kelas.id_jurusan', 'left')
                    ->orderBy('tb_jurusan.jurusan, tb_kelas.kelas, tb_mapel.nama_mapel')
                    ->findAll();
    }

    /**
     * Get mata pelajaran by ID
     */
    public function getMapelById($id)
    {
        return $this->select('tb_mapel.*, users.nama_lengkap as nama_guru')
                    ->join('users', 'users.id = tb_mapel.user_id', 'left')
                    ->find($id);
    }

    /**
     * Get mata pelajaran by guru ID
     */
    public function getMapelByGuruId($guruId)
    {
        return $this->where('user_id', $guruId)->findAll();
    }

    /**
     * Create new mata pelajaran
     */
    public function createMapel($data)
    {
        return $this->insert($data);
    }

    /**
     * Update mata pelajaran
     */
    public function updateMapel($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete mata pelajaran
     */
    public function deleteMapel($id)
    {
        return $this->delete($id);
    }

    /**
     * Get mata pelajaran for dropdown
     */
    public function getMapelForDropdown()
    {
        $mapel = $this->findAll();
        $options = [];
        foreach ($mapel as $item) {
            $options[$item['id_mapel']] = $item['nama_mapel'];
        }
        return $options;
    }

    /**
     * Check if mata pelajaran name already exists
     */
    public function isMapelExists($namaMapel, $excludeId = null)
    {
        $builder = $this->where('nama_mapel', $namaMapel);
        if ($excludeId) {
            $builder->where('id_mapel !=', $excludeId);
        }
        return $builder->countAllResults() > 0;
    }
}