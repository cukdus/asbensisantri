<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
   // Adapted to use the unified `users` table for guru data
   protected $table = 'users';

   protected $primaryKey = 'id';

   protected $allowedFields = [
      'email',
      'username',
      'password_hash',
      'nuptk',
      'nama_lengkap',
      'jenis_kelamin',
      'alamat',
      'no_hp',
      'unique_code',
      'role',
      'active'
   ];

   public function cekGuru(string $unique_code)
   {
      $guru = $this->where('unique_code', $unique_code)
                   ->where('role', 'guru')
                   ->where('active', 1)
                   ->first();

      if (!$guru) {
         return null;
      }

      // Ensure array and legacy keys for compatibility
      if (is_object($guru)) {
         $guru = (array) $guru;
      }
      $guru['id_guru'] = $guru['id'] ?? null;
      $guru['nama_guru'] = $guru['nama_lengkap'] ?? ($guru['nama_guru'] ?? null);

      return $guru;
   }

   public function getAllGuru()
   {
      $rows = $this->where('role', 'guru')
                   ->orderBy('nama_lengkap', 'ASC')
                   ->findAll();

      // Map to legacy keys expected by views (nama_guru, id_guru)
      return array_map(function ($row) {
         if (is_object($row)) {
            $row = (array) $row;
         }
         $row['id_guru'] = $row['id'] ?? null;
         $row['nama_guru'] = $row['nama_lengkap'] ?? ($row['nama_guru'] ?? null);
         return $row;
      }, $rows);
   }

   public function getGuruById($id)
   {
      $row = $this->find($id);
      if (!$row) {
         return null;
      }
      if (is_object($row)) {
         $row = (array) $row;
      }
      $row['id_guru'] = $row['id'] ?? null;
      $row['nama_guru'] = $row['nama_lengkap'] ?? ($row['nama_guru'] ?? null);
      return $row;
   }

   public function createGuru($nuptk, $nama, $jenisKelamin, $alamat, $noHp)
   {
      // Generate basic email and username from name (ensuring uniqueness is handled at DB level)
      $base = strtolower(preg_replace('/\s+/', ' ', trim($nama)));
      $emailLocal = str_replace(' ', '.', $base);
      $usernameLocal = str_replace(' ', '', $base);

      $data = [
         'email' => $emailLocal . '@sekolah.com',
         'username' => $usernameLocal,
         'password_hash' => password_hash('123456', PASSWORD_DEFAULT),
         'nuptk' => $nuptk,
         'nama_lengkap' => $nama,
         'jenis_kelamin' => $jenisKelamin,
         'alamat' => $alamat,
         'no_hp' => $noHp,
         'role' => 'guru',
         'active' => 1,
         'unique_code' => sha1($nama . md5($nuptk . $nama . $noHp)) . substr(sha1($nuptk . rand(0, 100)), 0, 24)
      ];

      return $this->save($data);
   }

   public function updateGuru($id, $nuptk, $nama, $jenisKelamin, $alamat, $noHp)
   {
      return $this->save([
         $this->primaryKey => $id,
         'nuptk' => $nuptk,
         'nama_lengkap' => $nama,
         'jenis_kelamin' => $jenisKelamin,
         'alamat' => $alamat,
         'no_hp' => $noHp,
      ]);
   }
}
