<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= $title ?? 'Sistem Absensi QR Code' ?></title>
    <meta name="description" content="Sistem Absensi Digital Berbasis QR Code untuk Sekolah Modern" />
    <meta name="keywords" content="absensi, qr code, sekolah, digital, sistem" />

    <!-- Favicons -->
    <link href="<?= base_url('favicon.ico') ?>" rel="icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #16a34a;
            --secondary-color: #065f46;
            --accent-color: #22c55e;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .btn-primary-custom {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid white;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: transparent;
            color: white;
            border-color: white;
        }

        .btn-outline-custom {
            background-color: transparent;
            color: white;
            border: 2px solid white;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background-color: white;
            color: var(--primary-color);
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-light);
            margin-bottom: 3rem;
        }

        .footer {
            background: var(--secondary-color);
            color: white;
            padding: 3rem 0 1rem;
        }

        .qr-demo {
            max-width: 200px;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--primary-color);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
                <i class="bi bi-qr-code-scan me-2"></i>
                AbsensiQR
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2 px-3" href="<?= base_url('scan/masuk') ?>">
                            <i class="bi bi-qr-code-scan me-1"></i>
                            Scan Absensi
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title">Sistem Absensi Digital Berbasis QR Code</h1>
                    <p class="hero-subtitle">
                        Revolusi cara absensi di sekolah Anda dengan teknologi QR Code yang modern, 
                        cepat, dan akurat. Kelola kehadiran siswa dan guru dengan mudah.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="<?= base_url('scan/masuk') ?>" class="btn btn-primary-custom btn-lg">
                            <i class="bi bi-qr-code-scan me-2"></i>
                            Mulai Absensi
                        </a>
                        <a href="#fitur" class="btn btn-outline-custom btn-lg">
                            <i class="bi bi-info-circle me-2"></i>
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="qr-demo">
                        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDIwMCAyMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMjAwIiBmaWxsPSJ3aGl0ZSIgcng9IjEwIi8+CjxyZWN0IHg9IjIwIiB5PSIyMCIgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSJibGFjayIvPgo8cmVjdCB4PSIzMCIgeT0iMzAiIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgZmlsbD0id2hpdGUiLz4KPHJlY3QgeD0iNDAiIHk9IjQwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEyMCIgeT0iMjAiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMTMwIiB5PSIzMCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSJ3aGl0ZSIvPgo8cmVjdCB4PSIxNDAiIHk9IjQwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjIwIiB5PSIxMjAiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgZmlsbD0iYmxhY2siLz4KPHJlY3QgeD0iMzAiIHk9IjEzMCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSJ3aGl0ZSIvPgo8cmVjdCB4PSI0MCIgeT0iMTQwIiB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEwMCIgeT0iMTAwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEyMCIgeT0iMTAwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjE0MCIgeT0iMTAwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjE2MCIgeT0iMTAwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEwMCIgeT0iMTIwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjE0MCIgeT0iMTIwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEwMCIgeT0iMTQwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEyMCIgeT0iMTQwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjE2MCIgeT0iMTQwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjEwMCIgeT0iMTYwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+CjxyZWN0IHg9IjE0MCIgeT0iMTYwIiB3aWR0aD0iMTAiIGhlaWdodD0iMTAiIGZpbGw9ImJsYWNrIi8+Cjwvc3ZnPgo=" 
                             alt="QR Code Demo" class="img-fluid" style="filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fitur" class="py-5" style="background-color: #f8fafc;">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Fitur Unggulan</h2>
                <p class="section-subtitle">Teknologi terdepan untuk sistem absensi yang efisien dan modern</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <h4 class="mb-3">Scan QR Code</h4>
                        <p class="text-muted">Absensi cepat dan akurat dengan teknologi QR Code. Cukup scan dan selesai!</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <h4 class="mb-3">Real-time Tracking</h4>
                        <p class="text-muted">Pantau kehadiran siswa dan guru secara real-time dengan dashboard yang informatif.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <h4 class="mb-3">Laporan Lengkap</h4>
                        <p class="text-muted">Generate laporan kehadiran yang detail dan dapat diekspor dalam berbagai format.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="mb-3">Keamanan Terjamin</h4>
                        <p class="text-muted">Sistem keamanan berlapis untuk melindungi data absensi dan privasi pengguna.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <h4 class="mb-3">Mobile Friendly</h4>
                        <p class="text-muted">Akses dari smartphone, tablet, atau komputer dengan tampilan yang responsif.</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card text-center">
                        <div class="feature-icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="mb-3">Multi User</h4>
                        <p class="text-muted">Mendukung berbagai jenis pengguna: siswa, guru, dan administrator sekolah.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Tentang Sistem Absensi QR</h2>
                    <p class="section-subtitle">
                        Sistem absensi digital yang dirancang khusus untuk memenuhi kebutuhan sekolah modern 
                        dalam mengelola kehadiran siswa dan guru dengan efisien.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <span>Mudah Digunakan</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <span>Hemat Waktu</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <span>Data Akurat</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle p-2 me-3">
                                    <i class="bi bi-check-lg"></i>
                                </div>
                                <span>Paperless</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgdmlld0JveD0iMCAwIDQwMCAzMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSI0MDAiIGhlaWdodD0iMzAwIiBmaWxsPSIjZjNmNGY2Ii8+CjxyZWN0IHg9IjUwIiB5PSI1MCIgd2lkdGg9IjMwMCIgaGVpZ2h0PSIyMDAiIGZpbGw9IndoaXRlIiBzdHJva2U9IiNlNWU3ZWIiIHN0cm9rZS13aWR0aD0iMiIgcng9IjEwIi8+CjxyZWN0IHg9IjgwIiB5PSI4MCIgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjMTZhMzRhIi8+CjxyZWN0IHg9IjkwIiB5PSI5MCIgd2lkdGg9IjYwIiBoZWlnaHQ9IjYwIiBmaWxsPSJ3aGl0ZSIvPgo8cmVjdCB4PSIxMDAiIHk9IjEwMCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBmaWxsPSIjMTZhMzRhIi8+Cjx0ZXh0IHg9IjIwMCIgeT0iMTIwIiBmb250LWZhbWlseT0iQXJpYWwiIGZvbnQtc2l6ZT0iMjQiIGZvbnQtd2VpZ2h0PSJib2xkIiBmaWxsPSIjMWYyOTM3Ij5TaXN0ZW0gQWJzZW5zaTwvdGV4dD4KPHRleHQgeD0iMjAwIiB5PSIxNTAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxNiIgZmlsbD0iIzZiNzI4MCI+UVIgQ29kZSBEaWdpdGFsPC90ZXh0Pgo8Y2lyY2xlIGN4PSIzMDAiIGN5PSIyMDAiIHI9IjIwIiBmaWxsPSIjMjJjNTVlIi8+CjxjaXJjbGUgY3g9IjI1MCIgY3k9IjIyMCIgcj0iMTUiIGZpbGw9IiMxNmEzNGEiLz4KPGNpcmNsZSBjeD0iMzIwIiBjeT0iMTgwIiByPSIxMiIgZmlsbD0iIzIyYzU1ZSIvPgo8L3N2Zz4K" 
                         alt="Sistem Absensi" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" style="background-color: #16a34a !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-qr-code-scan me-2"></i>
                        AbsensiQR
                    </h5>
                    <p class="mb-3">
                        Sistem absensi digital berbasis QR Code untuk sekolah modern. 
                        Mudah, cepat, dan akurat.
                    </p>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Menu</h6>
                    <ul class="list-unstyled">
                        <li><a href="#beranda" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li><a href="#fitur" class="text-white-50 text-decoration-none">Fitur</a></li>
                        <li><a href="#tentang" class="text-white-50 text-decoration-none">Tentang</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="fw-bold mb-3">Akses Cepat</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?= base_url('scan/masuk') ?>" class="text-white-50 text-decoration-none">Scan Masuk</a></li>
                        <li><a href="<?= base_url('scan/pulang') ?>" class="text-white-50 text-decoration-none">Scan Pulang</a></li>
                        <li><a href="<?= base_url('admin') ?>" class="text-white-50 text-decoration-none">Admin Panel</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="fw-bold mb-3">Kontak</h6>
                    <p class="text-white-50 mb-1">
                        <i class="bi bi-envelope me-2"></i>
                        info@absensiQR.com
                    </p>
                    <p class="text-white-50 mb-1">
                        <i class="bi bi-phone me-2"></i>
                        +62 123 456 789
                    </p>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white-50 mb-0">
                        &copy; <?= date('Y') ?> AbsensiQR. Semua hak dilindungi.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('scan/masuk') ?>" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-qr-code-scan me-1"></i>
                        Mulai Scan
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scrolling -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>