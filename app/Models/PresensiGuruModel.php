<?php

namespace App\Models;

use App\Libraries\enums\Kehadiran;
use App\Models\PresensiInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class PresensiGuruModel extends Model implements PresensiInterface
{
    protected $primaryKey = 'id_presensi';

    protected $allowedFields = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'id_kehadiran',
        'keterangan'
    ];

    protected $table = 'tb_presensi_guru';

    public function cekAbsen(string|int $id, string|Time $date)
    {
        $result = $this->where(['user_id' => $id, 'tanggal' => $date])
                      ->first();

        return $result;
    }

    public function absenMasuk($id, $date, $time)
    {
        try {
            $data = [
                'user_id' => $id,
                'tanggal' => $date,
                'jam_masuk' => $time,
                'id_kehadiran' => Kehadiran::Hadir->value,
                'keterangan' => ''
            ];

            return $this->insert($data);
        } catch (\Exception $e) {
            log_message('error', 'Error saat absen masuk guru: ' . $e->getMessage());
            return false;
        }
    }

    public function absenKeluar($id, $time)
    {
        try {
            // Pastikan id adalah integer
            $id = (int) $id;

            $data = [
                'jam_keluar' => $time,
                'keterangan' => ''
            ];

            // Debug
            log_message('info', 'Mencoba update presensi guru ID: ' . $id . ' dengan data: ' . json_encode($data));

            // Gunakan query builder langsung untuk memastikan data terupdate
            $result = $this
                ->db
                ->table($this->table)
                ->where($this->primaryKey, $id)
                ->update($data);

            if ($result === false) {
                log_message('error', 'Gagal update presensi guru: ' . json_encode($this->db->error()));
            }

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'Error saat absen keluar guru: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            return false;  // Return false instead of throwing exception
        }
    }

    public function getPresensiByIdGuruTanggal($idGuru, $date)
    {
        return $this->where(['user_id' => $idGuru, 'tanggal' => $date])
                   ->first();
    }

    public function getPresensiById(string $idPresensi)
    {
        return $this->where([$this->primaryKey => $idPresensi])->first();
    }

    public function getPresensiByTanggal($tanggal)
    {
        $builder = $this->db->table('users');
        return $builder
            ->select('users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.id_presensi, tb_presensi_guru.tanggal, tb_presensi_guru.jam_masuk, tb_presensi_guru.jam_keluar, tb_presensi_guru.id_kehadiran, tb_presensi_guru.keterangan, tb_kehadiran.kehadiran')
            ->join(
                'tb_presensi_guru',
                "users.id = tb_presensi_guru.user_id AND tb_presensi_guru.tanggal = '$tanggal'",
                'left'
            )
            ->join(
                'tb_kehadiran',
                'tb_presensi_guru.id_kehadiran = tb_kehadiran.id_kehadiran',
                'left'
            )
            ->where('users.role', 'guru')
            ->orderBy('users.nama_lengkap')
            ->get()
            ->getResultArray();
    }

    public function getPresensiByKehadiran(string $idKehadiran, $tanggal)
    {
        if ($idKehadiran == '4') {
            // Untuk alfa, ambil guru yang tidak ada presensi atau id_kehadiran bukan 1,2,3
            $builder = $this->db->table('users');
            $result = $builder
                ->select('users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.id_kehadiran')
                ->join(
                    'tb_presensi_guru',
                    "users.id = tb_presensi_guru.user_id AND tb_presensi_guru.tanggal = '$tanggal'",
                    'left'
                )
                ->where('users.role', 'guru')
                ->where('(tb_presensi_guru.id_kehadiran IS NULL OR tb_presensi_guru.id_kehadiran NOT IN (1,2,3))')
                ->get()
                ->getResultArray();

            return $result;
        } else {
            $builder = $this->db->table('users');
            return $builder
                ->select('users.id, users.nama_lengkap, users.nuptk, users.jenis_kelamin, users.alamat, users.no_hp, users.unique_code, tb_presensi_guru.*')
                ->join(
                    'tb_presensi_guru',
                    "users.id = tb_presensi_guru.user_id AND tb_presensi_guru.tanggal = '$tanggal'",
                    'inner'
                )
                ->where('users.role', 'guru')
                ->where([
                    'tb_presensi_guru.id_kehadiran' => $idKehadiran
                ])
                ->get()
                ->getResultArray();
        }
    }

    public function updatePresensi(
        $idPresensi,
        $idGuru,
        $tanggal,
        $idKehadiran,
        $jamMasuk,
        $jamKeluar,
        $keterangan
    ) {
        $presensi = $this->getPresensiByIdGuruTanggal($idGuru, $tanggal);

        $data = [
            'user_id' => $idGuru,
            'tanggal' => $tanggal,
            'id_kehadiran' => $idKehadiran,
            'keterangan' => $keterangan ?? $presensi['keterangan'] ?? ''
        ];

        if ($idPresensi != null) {
            $data[$this->primaryKey] = $idPresensi;
        }

        if ($jamMasuk != null) {
            $data['jam_masuk'] = $jamMasuk;
        }

        if ($jamKeluar != null) {
            $data['jam_keluar'] = $jamKeluar;
        }

        return $this->save($data);
    }
}
