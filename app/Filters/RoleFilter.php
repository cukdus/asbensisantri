<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in
        if (!logged_in()) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = user();
        $userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');

        // If no specific role required, just check if logged in
        if (empty($arguments)) {
            return;
        }

        $requiredRoles = is_array($arguments) ? $arguments : [$arguments];

        // Check if user has required role
        if (!in_array($userRole, $requiredRoles)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk halaman ini.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
