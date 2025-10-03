<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $protectFields = true;

    protected $allowedFields = [
        'email',
        'username',
        'nuptk',
        'nama_lengkap',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'foto',
        'unique_code',
        'role',
        'password_hash',
        'is_superadmin',
        'active',
        'status',
        'status_message'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'username' => 'permit_empty|alpha_numeric_punct|min_length[3]|max_length[30]|is_unique[users.username,id,{id}]',
        'nama_lengkap' => 'permit_empty|max_length[255]',
        'role' => 'required|in_list[superadmin,guru]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah digunakan.'
        ],
        'username' => [
            'is_unique' => 'Username sudah digunakan.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Role-based methods
    public function getAllUsers($role = null)
    {
        if ($role) {
            return $this->where('role', $role)->orderBy('nama_lengkap')->findAll();
        }
        return $this->orderBy('nama_lengkap')->findAll();
    }

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->orderBy('nama_lengkap')->findAll();
    }

    public function getAllGuru()
    {
        return $this->where('role', 'guru')->orderBy('nama_lengkap')->findAll();
    }

    public function getAllSuperadmin()
    {
        return $this->where('role', 'superadmin')->orderBy('nama_lengkap')->findAll();
    }

    public function getAllPetugas()
    {
        return $this->where('role', 'petugas')->orderBy('nama_lengkap')->findAll();
    }

    public function getUserById($id)
    {
        return $this->where([$this->primaryKey => $id])->first();
    }

    public function getUserByUniqueCode($unique_code)
    {
        return $this->where(['unique_code' => $unique_code])->first();
    }

    public function getUserByEmail($email)
    {
        return $this->where(['email' => $email])->first();
    }

    public function getUserByUsername($username)
    {
        return $this->where(['username' => $username])->first();
    }

    // Legacy method for guru compatibility
    public function cekGuru(string $unique_code)
    {
        $guru = $this
            ->where('unique_code', $unique_code)
            ->where('role', 'guru')
            ->where('active', 1)
            ->first();

        if ($guru) {
            // Menyesuaikan format data agar kompatibel dengan format lama
            $guru['id_guru'] = $guru['id'];
            $guru['nama_guru'] = $guru['nama_lengkap'];
            // Pastikan semua field yang dibutuhkan tersedia
            if (!isset($guru['nuptk'])) {
                $guru['nuptk'] = '-';
            }
        }

        return $guru;
    }

    // Create new user (guru or superadmin)
    public function createUser($data)
    {
        // Generate unique_code for guru
        if ($data['role'] === 'guru' && !isset($data['unique_code'])) {
            $data['unique_code'] = $this->generateUniqueCode($data['nama_lengkap'], $data['nuptk'] ?? '', $data['no_hp'] ?? '');
        }

        // Set default password if not provided
        if (!isset($data['password_hash'])) {
            $data['password_hash'] = password_hash('123456', PASSWORD_DEFAULT);
        }

        // Set active status
        if (!isset($data['active'])) {
            $data['active'] = 1;
        }

        return $this->save($data);
    }

    // Create guru (legacy compatibility)
    public function createGuru($nuptk, $nama, $jenisKelamin, $alamat, $noHp)
    {
        $data = [
            'email' => strtolower(str_replace(' ', '.', $nama)) . '@sekolah.com',
            'username' => strtolower(str_replace(' ', '', $nama)),
            'nuptk' => $nuptk,
            'nama_lengkap' => $nama,
            'jenis_kelamin' => $jenisKelamin,
            'alamat' => $alamat,
            'no_hp' => $noHp,
            'role' => 'guru'
        ];

        return $this->createUser($data);
    }

    // Update user
    public function updateUser($id, $data, $skipValidation = true)
    {
        // Remove id from data to avoid conflicts
        unset($data['id']);

        // Skip validation when called from controller (controller already validates)
        $originalSkipValidation = $this->skipValidation;
        if ($skipValidation) {
            $this->skipValidation = true;
        }

        try {
            $result = $this->update($id, $data);

            if (!$result) {
                $errors = $this->errors();
                log_message('error', 'UserModel update failed. Errors: ' . json_encode($errors));
                log_message('error', 'UserModel update data: ' . json_encode($data));
                log_message('error', 'UserModel update ID: ' . $id);
            }

            return $result;
        } catch (\Exception $e) {
            log_message('error', 'UserModel update exception: ' . $e->getMessage());
            log_message('error', 'UserModel update data: ' . json_encode($data));
            log_message('error', 'UserModel update ID: ' . $id);
            throw $e;
        } finally {
            // Restore original skipValidation setting
            $this->skipValidation = $originalSkipValidation;
        }
    }

    // Update guru (legacy compatibility)
    public function updateGuru($id, $nuptk, $nama, $jenisKelamin, $alamat, $noHp)
    {
        $data = [
            'nuptk' => $nuptk,
            'nama_lengkap' => $nama,
            'jenis_kelamin' => $jenisKelamin,
            'alamat' => $alamat,
            'no_hp' => $noHp,
        ];

        return $this->updateUser($id, $data);
    }

    // Create/Update petugas (legacy compatibility)
    public function savePetugas($idPetugas, $email, $username, $passwordHash, $role)
    {
        $data = [
            'email' => $email,
            'username' => $username,
            'password_hash' => $passwordHash,
            'role' => $role === '1' ? 'superadmin' : 'guru',
            'is_superadmin' => $role ?? '0',
        ];

        if ($idPetugas) {
            return $this->updateUser($idPetugas, $data);
        } else {
            return $this->createUser($data);
        }
    }

    // Check if user has specific role
    public function hasRole($userId, $role)
    {
        $user = $this->getUserById($userId);
        return $user && $user['role'] === $role;
    }

    public function isSuperadmin($userId)
    {
        return $this->hasRole($userId, 'superadmin');
    }

    public function isGuru($userId)
    {
        return $this->hasRole($userId, 'guru');
    }

    // Generate unique code for guru
    public function generateUniqueCode($nama, $nuptk, $noHp)
    {
        return sha1($nama . md5($nuptk . $nama . $noHp)) . substr(sha1($nuptk . rand(0, 100)), 0, 24);
    }

    // Get user statistics
    public function getUserStats()
    {
        return [
            'total_users' => $this->countAll(),
            'total_guru' => $this->where('role', 'guru')->countAllResults(),
            'total_superadmin' => $this->where('role', 'superadmin')->countAllResults(),
            'active_users' => $this->where('active', 1)->countAllResults()
        ];
    }
}
