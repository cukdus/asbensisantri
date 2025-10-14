<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthPage extends BaseController
{
    public function login()
    {
        // Tetapkan redirect pasca-login ke dashboard admin
        session()->set('redirect_url', site_url('admin'));

        // Render halaman login menggunakan view yang dikonfigurasi
        $config = config('Auth');
        return view($config->views['login'], ['config' => $config]);
    }

    public function logout()
    {
        // Logout menggunakan service authentication
        service('authentication')->logout();

        // Kembali ke halaman login setelah logout
        return redirect()->to(site_url('login'));
    }
}