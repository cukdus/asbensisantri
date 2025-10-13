<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Landing extends Controller
{
    public function index()
    {
        return redirect()->to('/ponpes/index.html');
    }
}