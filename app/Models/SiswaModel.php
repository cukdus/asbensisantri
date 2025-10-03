<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected function initialize()
    {
        $this->allowedFields = [
            'nis',
            'nama_siswa',
            'id_kelas',
            'jenis_kelamin',
            'no_hp',
            'foto',
            'is_graduated',
            'nama_orang_tua',
            'alamat',
            'tahun_masuk',
            'unique_code'
        ];
    }

    protected $table = 'tb_siswa';

    protected $primaryKey = 'id_siswa';

    public function cekSiswa(string $unique_code)
    {
        $this->join(
            'tb_kelas',
            'tb_kelas.id_kelas = tb_siswa.id_kelas',
            'LEFT'
        )->join(
            'tb_jurusan',
            'tb_jurusan.id = tb_kelas.id_jurusan',
            'LEFT'
        );
        return $this->where(['unique_code' => $unique_code])->first();
    }

    public function getSiswaById($id)
    {
        return $this->join(
            'tb_kelas',
            'tb_kelas.id_kelas = tb_siswa.id_kelas',
            'LEFT'
        )->join(
            'tb_jurusan',
            'tb_kelas.id_jurusan = tb_jurusan.id',
            'LEFT'
        )->where([$this->primaryKey => $id])->first();
    }

    public function getAllSiswaWithKelas($kelas = null, $jurusan = null)
    {
        $query = $this->join(
            'tb_kelas',
            'tb_kelas.id_kelas = tb_siswa.id_kelas',
            'LEFT'
        )->join(
            'tb_jurusan',
            'tb_kelas.id_jurusan = tb_jurusan.id',
            'LEFT'
        );

        if (!empty($kelas) && !empty($jurusan)) {
            $query = $this->where(['kelas' => $kelas, 'jurusan' => $jurusan]);
        } else if (empty($kelas) && !empty($jurusan)) {
            $query = $this->where(['jurusan' => $jurusan]);
        } else if (!empty($kelas) && empty($jurusan)) {
            $query = $this->where(['kelas' => $kelas]);
        } else {
            $query = $this;
        }

        return $query->orderBy('nama_siswa')->findAll();
    }

    public function getAlumniCount()
    {
        return $this->where('is_graduated', 1)->countAllResults();
    }

    public function getSiswaByKelas($id_kelas)
    {
        return $this
            ->join(
                'tb_kelas',
                'tb_kelas.id_kelas = tb_siswa.id_kelas',
                'LEFT'
            )
            ->join('tb_jurusan', 'tb_kelas.id_jurusan = tb_jurusan.id', 'left')
            ->where(['tb_siswa.id_kelas' => $id_kelas])
            ->orderBy('nama_siswa')
            ->findAll();
    }

    /**
     * Generate auto NIS with format: PSMA + year + gender code + sequential number
     * Example: PSMA25010001
     * - PSMA: school code (Pondok Pesantren Sirojan Muniro Assalam)
     * - 25: year (2025)
     * - 01: gender code (01 = male, 02 = female)
     * - 0001: sequential number per year
     */
    public function generateNIS($jenisKelamin, $tahunMasuk)
    {
        // School code
        $schoolCode = 'PSMA';

        // Year (last 2 digits)
        $year = substr($tahunMasuk, -2);

        // Gender code
        $genderCode = ($jenisKelamin === 'Laki-laki') ? '01' : '02';

        // Get the next sequential number for this year and gender
        $prefix = $schoolCode . $year . $genderCode;

        // Find the highest existing number for this prefix
        $lastStudent = $this
            ->like('nis', $prefix, 'after')
            ->orderBy('nis', 'DESC')
            ->first();

        $sequentialNumber = 1;
        if ($lastStudent && !empty($lastStudent['nis'])) {
            // Extract the last 4 digits and increment
            $lastSequence = substr($lastStudent['nis'], -4);
            $sequentialNumber = intval($lastSequence) + 1;
        }

        // Format sequential number to 4 digits with leading zeros
        $formattedSequence = str_pad($sequentialNumber, 4, '0', STR_PAD_LEFT);

        return $prefix . $formattedSequence;
    }

    public function createSiswa($nama, $idKelas, $jenisKelamin, $noHp, $tahunMasuk, $foto = null, $namaOrangTua = null, $alamat = null)
    {
        // Auto-generate NIS
        $nis = $this->generateNIS($jenisKelamin, $tahunMasuk);

        $data = [
            'nis' => $nis,
            'nama_siswa' => $nama,
            'id_kelas' => $idKelas,
            'jenis_kelamin' => $jenisKelamin,
            'no_hp' => $noHp,
            'tahun_masuk' => $tahunMasuk,
            'unique_code' => generateToken()
        ];

        // Add optional fields if provided
        if ($foto !== null) {
            $data['foto'] = $foto;
        }
        if ($namaOrangTua !== null) {
            $data['nama_orang_tua'] = $namaOrangTua;
        }
        if ($alamat !== null) {
            $data['alamat'] = $alamat;
        }

        return $this->save($data);
    }

    public function updateSiswa($id, $nama, $idKelas, $jenisKelamin, $noHp, $foto = null, $namaOrangTua = null, $alamat = null, $tahunMasuk = null)
    {
        $data = [
            $this->primaryKey => $id,
            'nama_siswa' => $nama,
            'id_kelas' => $idKelas,
            'jenis_kelamin' => $jenisKelamin,
            'no_hp' => $noHp,
        ];

        // Add optional fields if provided
        if ($foto !== null) {
            $data['foto'] = $foto;
        }
        if ($namaOrangTua !== null) {
            $data['nama_orang_tua'] = $namaOrangTua;
        }
        if ($alamat !== null) {
            $data['alamat'] = $alamat;
        }
        if ($tahunMasuk !== null) {
            $data['tahun_masuk'] = $tahunMasuk;
        }

        return $this->save($data);
    }

    public function getSiswaCountByKelas($kelasId)
    {
        $tree = array();
        $kelasId = cleanNumber($kelasId);
        if (!empty($kelasId)) {
            array_push($tree, $kelasId);
        }

        $kelasIds = $tree;
        if (countItems($kelasIds) < 1) {
            return array();
        }

        return $this->whereIn('tb_siswa.id_kelas', $kelasIds, false)->countAllResults();
    }

    // generate CSV object
    public function generateCSVObject($filePath)
    {
        $array = array();
        $fields = array();
        $txtName = uniqid() . '.txt';
        $i = 0;
        $handle = fopen($filePath, 'r');
        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k => $value) {
                    $array[$i][$fields[$k]] = $value;
                }
                $i++;
            }
            if (!feof($handle)) {
                return false;
            }
            fclose($handle);
            if (!empty($array)) {
                $txtFile = fopen(FCPATH . 'uploads/tmp/' . $txtName, 'w');
                fwrite($txtFile, serialize($array));
                fclose($txtFile);
                $obj = new \stdClass();
                $obj->numberOfItems = countItems($array);
                $obj->txtFileName = $txtName;
                @unlink($filePath);
                return $obj;
            }
        }
        return false;
    }

    // import csv item
    public function importCSVItem($txtFileName, $index)
    {
        $filePath = FCPATH . 'uploads/tmp/' . $txtFileName;
        $file = fopen($filePath, 'r');
        $content = fread($file, filesize($filePath));
        $array = @unserialize($content);
        if (!empty($array)) {
            $i = 1;
            foreach ($array as $item) {
                if ($i == $index) {
                    $data = array();
                    $data['nis'] = getCSVInputValue($item, 'nis', 'int');
                    $data['nama_siswa'] = getCSVInputValue($item, 'nama_siswa');
                    $data['id_kelas'] = getCSVInputValue($item, 'id_kelas', 'int');
                    $data['jenis_kelamin'] = getCSVInputValue($item, 'jenis_kelamin');
                    $data['no_hp'] = getCSVInputValue($item, 'no_hp');
                    $data['unique_code'] = generateToken();

                    $this->insert($data);
                    return $data;
                }
                $i++;
            }
        }
    }

    public function getSiswa($id)
    {
        return $this->where('id_siswa', cleanNumber($id))->get()->getRow();
    }

    // delete post
    public function deleteSiswa($id)
    {
        $siswa = $this->getSiswa($id);
        if (!empty($siswa)) {
            // delete siswa
            return $this->where('id_siswa', $siswa->id_siswa)->delete();
        }
        return false;
    }

    // delete multi post
    public function deleteMultiSelected($siswaIds)
    {
        if (!empty($siswaIds)) {
            foreach ($siswaIds as $id) {
                $this->deleteSiswa($id);
            }
        }
    }
}
