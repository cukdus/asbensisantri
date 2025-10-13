<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Sistem Absensi QR Code - Sekolah Digital'
        ];
        
        return view('home/index', $data);
    }
}