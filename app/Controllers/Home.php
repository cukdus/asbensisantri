<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Pondok Pesantren Sirojan Muniro As-Salam | Pendidikan Islam Terpadu'
        ];

        // Load latest YouTube videos for homepage section
        try {
            $yt = new \App\Libraries\YouTubeService();
            $data['youtubeVideos'] = $yt->getLatestVideos();
        } catch (\Throwable $e) {
            $data['youtubeVideos'] = [];
        }

        return view('home/index', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About - Pondok Pesantren Sirojan Muniro As-Salam'
        ];

        return view('home/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact - Pondok Pesantren Sirojan Muniro As-Salam'
        ];

        return view('home/contact', $data);
    }

    public function quran()
    {
        $data = [
            'title' => "Al-Qur'an - Pondok Pesantren Sirojan Muniro As-Salam"
        ];

        return view('home/quran', $data);
    }

    public function doa()
    {
        $data = [
            'title' => 'Doa & Dzikir - Pondok Pesantren Sirojan Muniro As-Salam'
        ];

        return view('home/doa', $data);
    }
}
