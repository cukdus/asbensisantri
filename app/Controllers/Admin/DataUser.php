<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Myth\Auth\Password;

class DataUser extends BaseController
{
    protected UserModel $userModel;

    protected $userValidationRules = [
        'id' => [
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'ID user harus ada',
                'numeric' => 'ID user harus berupa angka'
            ]
        ],
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Email harus diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini telah terdaftar.'
            ]
        ],
        'username' => [
            'rules' => 'required|min_length[6]',
            'errors' => [
                'required' => 'Username harus diisi',
                'min_length' => 'Username minimal 6 karakter',
                'is_unique' => 'Username ini telah terdaftar.'
            ]
        ],
        'password' => [
            'rules' => 'permit_empty|min_length[6]',
            'errors' => [
                'min_length' => 'Password minimal 6 karakter'
            ]
        ],
        'role' => [
            'rules' => 'required|in_list[guru,superadmin]',
            'errors' => [
                'required' => 'Role wajib diisi',
                'in_list' => 'Role harus guru atau superadmin'
            ]
        ],
        'nama_lengkap' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama lengkap harus diisi'
            ]
        ],
        'jenis_kelamin' => [
            'rules' => 'required|in_list[L,P]',
            'errors' => [
                'required' => 'Jenis kelamin harus diisi',
                'in_list' => 'Jenis kelamin harus L atau P'
            ]
        ]
    ];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        // Allow both superadmin and guru to access user management
        if (!in_array($userRole, ['superadmin', 'guru'])) {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        // Determine context based on the current URI
        $currentUri = $this->request->getUri()->getPath();
        $context = 'user';  // default context
        $title = 'Data User';  // default title

        if (strpos($currentUri, '/admin/guru') !== false) {
            $context = 'guru';
            $title = 'Data Guru';
        }

        $data = [
            'title' => $title,
            'ctx' => $context,
            'userRole' => $userRole
        ];

        return view('admin/user/data-user', $data);
    }

    public function ambilDataUser()
    {
        $role = $this->request->getPost('role');
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        // Check if accessed via guru route
        $currentUri = $this->request->getUri()->getPath();
        $isGuruRoute = strpos($currentUri, '/admin/guru') !== false;

        if ($role) {
            $users = $this->userModel->getUsersByRole($role);
        } else if ($isGuruRoute) {
            // If accessed via guru route, only show guru data
            $users = $this->userModel->getUsersByRole('guru');
        } else {
            $users = $this->userModel->getAllUsers();
        }

        $data = [
            'data' => $users,
            'empty' => empty($users),
            'userRole' => $userRole
        ];

        return view('admin/user/list-data-user', $data);
    }

    public function bulkDelete()
    {
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if ($userRole !== 'superadmin') {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $ids = $this->request->getPost('ids');

        if (empty($ids) || !is_array($ids)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No data selected']);
        }

        $deletedCount = 0;
        foreach ($ids as $id) {
            if ($this->userModel->delete($id)) {
                $deletedCount++;
            }
        }

        if ($deletedCount > 0) {
            return $this->response->setJSON([
                'success' => true,
                'message' => $deletedCount . ' user berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus data'
            ]);
        }
    }

    public function registerUser()
    {
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if ($userRole !== 'superadmin') {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        $data = [
            'title' => 'Tambah User',
            'ctx' => 'user'
        ];

        return view('admin/user/register', $data);
    }

    /**
     * Convert jenis_kelamin from form value to database value
     */
    private function convertJenisKelamin($value)
    {
        switch ($value) {
            case 'L':
                return 'Laki-laki';
            case 'P':
                return 'Perempuan';
            default:
                return $value;  // Return as is if already in correct format
        }
    }

    public function saveUser()
    {
        // Create validation rules for new user (excluding id field)
        $createValidationRules = $this->userValidationRules;
        unset($createValidationRules['id']);  // Remove id validation for new user creation

        // Add unique validation for new user
        $createValidationRules['email']['rules'] = 'required|valid_email|is_unique[users.email]';
        $createValidationRules['username']['rules'] = 'required|min_length[6]|is_unique[users.username]';
        $createValidationRules['password']['rules'] = 'required|min_length[6]';

        if (!$this->validate($createValidationRules)) {
            $data = [
                'title' => 'Tambah User',
                'ctx' => 'user',
                'validation_errors' => $this->validator->getErrors(),
                'oldInput' => $this->request->getVar()
            ];
            return view('admin/user/register', $data);
        }

        $userData = [
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'password_hash' => Password::hash($this->request->getVar('password')),
            'role' => $this->request->getVar('role'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'jenis_kelamin' => $this->convertJenisKelamin($this->request->getVar('jenis_kelamin')),
            'alamat' => $this->request->getVar('alamat'),
            'no_hp' => $this->request->getVar('no_hp'),
            'nuptk' => $this->request->getVar('nuptk'),
            'is_superadmin' => $this->request->getVar('role') === 'superadmin' ? 1 : 0,
            'active' => 1,
            'status' => 'activated'
        ];

        // Generate unique_code for guru
        if ($userData['role'] === 'guru') {
            $userData['unique_code'] = $this->userModel->generateUniqueCode(
                $userData['nama_lengkap'],
                $userData['nuptk'] ?? '',
                $userData['no_hp'] ?? ''
            );
        }

        $result = $this->userModel->createUser($userData);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'User berhasil ditambahkan',
                'error' => false
            ]);
            return redirect()->to('/admin/user');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menambahkan user',
            'error' => true
        ]);
        return redirect()->to('/admin/user/register');
    }

    public function formEditUser($id)
    {
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if ($userRole !== 'superadmin') {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        $userData = $this->userModel->getUserById($id);

        if (empty($userData)) {
            throw new PageNotFoundException('Data user dengan id ' . $id . ' tidak ditemukan');
        }

        $data = [
            'data' => $userData,
            'ctx' => 'user',
            'title' => 'Edit Data User',
        ];

        return view('admin/user/edit-data-user', $data);
    }

    public function updateUser()
    {
        $idUser = $this->request->getVar('id');
        $userLama = $this->userModel->getUserById($idUser);

        // Create validation rules for update (excluding id field)
        $updateValidationRules = $this->userValidationRules;
        unset($updateValidationRules['id']);  // Remove id validation for update

        // Handle unique validation for username
        if ($userLama['username'] != $this->request->getVar('username')) {
            $updateValidationRules['username']['rules'] = 'required|min_length[6]|is_unique[users.username]';
        } else {
            // If username is not changed, remove is_unique validation
            $updateValidationRules['username']['rules'] = 'required|min_length[6]';
        }

        // Handle unique validation for email
        if ($userLama['email'] != $this->request->getVar('email')) {
            $updateValidationRules['email']['rules'] = 'required|valid_email|is_unique[users.email]';
        } else {
            // If email is not changed, remove is_unique validation
            $updateValidationRules['email']['rules'] = 'required|valid_email';
        }

        if (!$this->validate($updateValidationRules)) {
            session()->setFlashdata([
                'msg' => 'Data tidak valid. Silakan periksa kembali.',
                'error' => true,
                'validation_errors' => $this->validator->getErrors(),
                'oldInput' => $this->request->getVar()
            ]);
            return redirect()->to('/admin/user/edit/' . $idUser);
        }

        $password = $this->request->getVar('password') ?? false;

        // Handle photo upload
        $fotoName = $userLama['foto'];  // Keep existing photo by default
        $foto = $this->request->getFile('foto');
        $removeFoto = $this->request->getVar('remove_foto');

        // Check if user wants to remove photo
        if ($removeFoto == '1') {
            // Delete old photo if exists
            if (!empty($userLama['foto'])) {
                $oldPhotoPath = FCPATH . 'uploads/users/' . $userLama['foto'];
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }
            }
            $fotoName = null;
        } elseif ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Validate file type and size
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            $maxSize = 2 * 1024 * 1024;  // 2MB

            if (!in_array($foto->getMimeType(), $allowedTypes)) {
                session()->setFlashdata([
                    'msg' => 'Format foto tidak didukung. Gunakan JPG, PNG, atau GIF.',
                    'error' => true
                ]);
                return redirect()->to('/admin/user/edit/' . $idUser);
            }

            if ($foto->getSize() > $maxSize) {
                session()->setFlashdata([
                    'msg' => 'Ukuran foto terlalu besar. Maksimal 2MB.',
                    'error' => true
                ]);
                return redirect()->to('/admin/user/edit/' . $idUser);
            }

            // Create uploads directory if not exists
            $uploadPath = FCPATH . 'uploads/users/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate unique filename
            $fotoName = $foto->getRandomName();

            // Move file to uploads directory
            if ($foto->move($uploadPath, $fotoName)) {
                // Delete old photo if exists
                if (!empty($userLama['foto'])) {
                    $oldPhotoPath = FCPATH . 'uploads/users/' . $userLama['foto'];
                    if (file_exists($oldPhotoPath)) {
                        unlink($oldPhotoPath);
                    }
                }
            } else {
                session()->setFlashdata([
                    'msg' => 'Gagal mengupload foto. Periksa permission folder uploads.',
                    'error' => true
                ]);
                return redirect()->to('/admin/user/edit/' . $idUser);
            }
        }

        $userData = [
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'role' => $this->request->getVar('role'),
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'jenis_kelamin' => $this->convertJenisKelamin($this->request->getVar('jenis_kelamin')),
            'alamat' => $this->request->getVar('alamat'),
            'no_hp' => $this->request->getVar('no_hp'),
            'nuptk' => $this->request->getVar('nuptk'),
            'foto' => $fotoName,
            'is_superadmin' => $this->request->getVar('role') === 'superadmin' ? 1 : 0
        ];

        if ($password) {
            $userData['password_hash'] = Password::hash($password);
        }

        try {
            $result = $this->userModel->updateUser($idUser, $userData);

            // Debug logging
            log_message('debug', 'UpdateUser result: ' . ($result ? 'true' : 'false'));
            log_message('debug', 'User ID: ' . $idUser);
            log_message('debug', 'User data: ' . json_encode($userData));
        } catch (\Exception $e) {
            log_message('error', 'UpdateUser error: ' . $e->getMessage());
            session()->setFlashdata([
                'msg' => 'Gagal mengubah data: ' . $e->getMessage(),
                'error' => true
            ]);
            return redirect()->to('/admin/user/edit/' . $idUser);
        }

        if ($result) {
            session()->setFlashdata([
                'msg' => 'User berhasil diubah',
                'error' => false
            ]);
            return redirect()->to('/admin/user');
        }

        session()->setFlashdata([
            'msg' => 'Gagal mengubah data',
            'error' => true
        ]);
        return redirect()->to('/admin/user/edit/' . $idUser);
    }

    public function delete($id)
    {
        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        if ($userRole !== 'superadmin') {
            return redirect()->to('admin')->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }

        $result = $this->userModel->delete($id);

        if ($result) {
            session()->setFlashdata([
                'msg' => 'Data berhasil dihapus',
                'error' => false
            ]);
            return redirect()->to('/admin/user');
        }

        session()->setFlashdata([
            'msg' => 'Gagal menghapus data',
            'error' => true
        ]);
        return redirect()->to('/admin/user');
    }
}
