<?php

namespace App\Models;

use Myth\Auth\Models\UserModel as MythUserModel;

class UserModel extends MythUserModel
{
    // Override soft delete configuration
    protected $useSoftDeletes = false;
    
    // Add custom fields for our application
    protected $allowedFields = [
        'email', 'username', 'password_hash', 'reset_hash', 'reset_at', 'reset_expires', 'activate_hash',
        'status', 'status_message', 'active', 'force_pass_reset', 'permissions',
        // Custom fields for our application
        'nuptk', 'nama_lengkap', 'jenis_kelamin', 'alamat', 'no_hp', 'foto', 'unique_code', 'role', 'is_superadmin'
    ];

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

    // Role-based methods
    public function getAllUsers($role = null)
    {
        if ($role) {
            return $this->where('role', $role)->orderBy('nama_lengkap', 'ASC')->findAll();
        }
        return $this->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    public function getAllGuru()
    {
        return $this->where('role', 'guru')->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    public function getAllSuperadmin()
    {
        return $this->where('role', 'superadmin')->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    public function getAllPetugas()
    {
        return $this->where('role', 'petugas')->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    // Generate unique code for guru
    public function generateUniqueCode($nama, $nuptk = '', $no_hp = '')
    {
        $timestamp = time();
        $randomString = bin2hex(random_bytes(16));
        $data = $nama . $nuptk . $no_hp . $timestamp;
        return hash('sha256', $data) . '-' . substr($randomString, 0, 8) . '-' . substr($randomString, 8, 8);
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

    // Update user data
    public function updateUser($id, $data)
    {
        // If role is guru and unique_code is not set, generate it
        if (isset($data['role']) && $data['role'] === 'guru' && !isset($data['unique_code'])) {
            $existingUser = $this->find($id);
            if ($existingUser && empty($existingUser->unique_code)) {
                $data['unique_code'] = $this->generateUniqueCode(
                    $data['nama_lengkap'] ?? $existingUser->nama_lengkap,
                    $data['nuptk'] ?? $existingUser->nuptk ?? '',
                    $data['no_hp'] ?? $existingUser->no_hp ?? ''
                );
            }
        }

        // Use builder to bypass model validation
        return $this->builder()->where('id', $id)->update($data);
    }

    // Get user by unique code (for guru)
    public function getUserByUniqueCode($uniqueCode)
    {
        return $this->where('unique_code', $uniqueCode)->first();
    }

    // Check if email exists
    public function emailExists($email, $excludeId = null)
    {
        $query = $this->where('email', $email);
        if ($excludeId) {
            $query->where('id !=', $excludeId);
        }
        return $query->first() !== null;
    }

    // Check if username exists
    public function usernameExists($username, $excludeId = null)
    {
        $query = $this->where('username', $username);
        if ($excludeId) {
            $query->where('id !=', $excludeId);
        }
        return $query->first() !== null;
    }

    // Get user with role information
    public function getUserWithRole($id)
    {
        return $this->find($id);
    }

    // Search users
    public function searchUsers($keyword, $role = null)
    {
        $query = $this->groupStart()
                      ->like('nama_lengkap', $keyword)
                      ->orLike('email', $keyword)
                      ->orLike('username', $keyword)
                      ->orLike('nuptk', $keyword)
                      ->groupEnd();
        
        if ($role) {
            $query->where('role', $role);
        }
        
        return $query->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    // Count users by role
    public function countByRole($role)
    {
        return $this->where('role', $role)->countAllResults();
    }

    // Get active users
    public function getActiveUsers($role = null)
    {
        $query = $this->where('active', 1);
        if ($role) {
            $query->where('role', $role);
        }
        return $query->orderBy('nama_lengkap', 'ASC')->findAll();
    }

    // Get user by ID
    public function getUserById($id)
    {
        $user = $this->find($id);
        return $user ? $user->toArray() : null;
    }

    // Check guru by unique code (for QR code scanning)
    public function cekGuru($unique_code)
    {
        $guru = $this->where('unique_code', $unique_code)
            ->where('role', 'guru')
            ->where('active', 1)
            ->first();

        if ($guru) {
            // Convert to array if it's an object
            if (is_object($guru)) {
                $guru = $guru->toArray();
            }
            
            // Map fields to match expected format
            $guru['id_guru'] = $guru['id'];
            $guru['nama_guru'] = $guru['nama_lengkap'];
            
            // Ensure nuptk field is available
            if (!isset($guru['nuptk']) || empty($guru['nuptk'])) {
                $guru['nuptk'] = '-';
            }
        }

        return $guru;
    }

    /**
     * Records a login attempt into the database.
     * Overrides parent method to use both 'email' and 'login' fields
     *
     * @param string $login    The login credential used (email or username)
     * @param bool   $success  Whether the login was successful
     * @param int    $userId   User ID if login was successful
     */
    public function recordLoginAttempt(string $login, bool $success, int $userId = null)
    {
        $data = [
            'ip_address' => service('request')->getIPAddress(),
            'email'      => $login, // Keep for backward compatibility
            'login'      => $login, // New field for accurate tracking
            'user_id'    => $userId,
            'date'       => date('Y-m-d H:i:s'),
            'success'    => $success ? 1 : 0,
        ];

        $db = \Config\Database::connect();
        $builder = $db->table('auth_logins');
        
        return $builder->insert($data);
    }
}