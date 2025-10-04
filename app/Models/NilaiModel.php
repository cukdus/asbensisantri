<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table = 'tb_nilai';
    protected $primaryKey = 'id_nilai';
    protected $allowedFields = ['id_siswa', 'id_mapel', 'id_kelas', 'nilai', 'semester', 'tahun_ajaran', 'keterangan'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all nilai with student and subject information
     */
    public function getAllNilai()
    {
        return $this->select('tb_nilai.*, tb_siswa.nama_siswa, tb_siswa.nis, tb_mapel.nama_mapel, tb_kelas.kelas')
                    ->join('tb_siswa', 'tb_siswa.id_siswa = tb_nilai.id_siswa')
                    ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_nilai.id_kelas')
                    ->orderBy('tb_nilai.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Get nilai by ID with relationships
     */
    public function getNilaiById($id)
    {
        return $this->select('tb_nilai.*, tb_siswa.nama_siswa, tb_siswa.nis, tb_mapel.nama_mapel, tb_kelas.kelas')
                    ->join('tb_siswa', 'tb_siswa.id_siswa = tb_nilai.id_siswa')
                    ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_nilai.id_kelas')
                    ->find($id);
    }

    /**
     * Get nilai by student ID
     */
    public function getNilaiBySiswaId($siswaId)
    {
        return $this->select('tb_nilai.*, tb_mapel.nama_mapel')
                    ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
                    ->where('tb_nilai.id_siswa', $siswaId)
                    ->findAll();
    }

    /**
     * Get nilai by mata pelajaran ID
     */
    public function getNilaiByMapelId($mapelId)
    {
        return $this->select('tb_nilai.*, tb_siswa.nama_siswa, tb_siswa.nis, tb_kelas.kelas')
                    ->join('tb_siswa', 'tb_siswa.id_siswa = tb_nilai.id_siswa')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
                    ->where('tb_nilai.id_mapel', $mapelId)
                    ->findAll();
    }

    /**
     * Get nilai by semester and tahun ajaran
     */
    public function getNilaiBySemesterTahun($semester, $tahunAjaran)
    {
        return $this->select('tb_nilai.*, tb_siswa.nama_siswa, tb_siswa.nis, tb_mapel.nama_mapel, tb_kelas.kelas')
                    ->join('tb_siswa', 'tb_siswa.id_siswa = tb_nilai.id_siswa')
                    ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas')
                    ->where('tb_nilai.semester', $semester)
                    ->where('tb_nilai.tahun_ajaran', $tahunAjaran)
                    ->findAll();
    }

    /**
     * Create new nilai
     */
    public function createNilai($data)
    {
        return $this->insert($data);
    }

    /**
     * Update nilai
     */
    public function updateNilai($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete nilai
     */
    public function deleteNilai($id)
    {
        return $this->delete($id);
    }

    /**
     * Check if nilai already exists for student and subject in same semester/tahun
     */
    public function isNilaiExists($siswaId, $mapelId, $semester, $tahunAjaran, $excludeId = null)
    {
        $builder = $this->where('id_siswa', $siswaId)
                        ->where('id_mapel', $mapelId)
                        ->where('semester', $semester)
                        ->where('tahun_ajaran', $tahunAjaran);
        
        if ($excludeId) {
            $builder->where('id_nilai !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Get nilai statistics
     */
    public function getNilaiStatistics()
    {
        $stats = [];
        
        // Count by semester
        $stats['semester'] = $this->select('semester, COUNT(*) as total')
                                  ->groupBy('semester')
                                  ->findAll();
        
        // Average nilai
        $stats['average'] = $this->selectAvg('nilai')->first();
        
        // Count total
        $stats['total'] = $this->countAllResults();
        
        return $stats;
    }

    /**
     * Get nilai with filters
     */
    public function getNilaiWithFilters($filters = [])
    {
        $builder = $this->select('tb_nilai.*, tb_siswa.nama_siswa, tb_siswa.nis, tb_mapel.nama_mapel, tb_kelas.kelas')
                        ->join('tb_siswa', 'tb_siswa.id_siswa = tb_nilai.id_siswa')
                        ->join('tb_mapel', 'tb_mapel.id_mapel = tb_nilai.id_mapel')
                        ->join('tb_kelas', 'tb_kelas.id_kelas = tb_siswa.id_kelas');

        if (!empty($filters['semester'])) {
            $builder->where('tb_nilai.semester', $filters['semester']);
        }

        if (!empty($filters['tahun_ajaran'])) {
            $builder->where('tb_nilai.tahun_ajaran', $filters['tahun_ajaran']);
        }

        if (!empty($filters['id_mapel'])) {
            $builder->where('tb_nilai.id_mapel', $filters['id_mapel']);
        }

        if (!empty($filters['id_kelas'])) {
            $builder->where('tb_siswa.id_kelas', $filters['id_kelas']);
        }

        return $builder->orderBy('tb_nilai.created_at', 'DESC')->findAll();
    }
}