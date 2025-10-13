<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pondok Pesantren Sirojan Muniro As-Salam | Pendidikan Islam Terpadu'
        ];

        return view('home/index', $data);
    }
}
