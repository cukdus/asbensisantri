<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= $title ?? 'Pondok Pesantren Sirojan Muniro As-Salam'; ?></title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <link href="<?= base_url('assets/img/favicon.png'); ?>" rel="icon" />
    <link href="<?= base_url('assets/img/apple-touch-icon.png'); ?>" rel="apple-touch-icon" />

    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" rel="stylesheet" />
    <link
      href="https://cdn.jsdelivr.net/npm/glightbox@3.2.0/dist/css/glightbox.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      crossorigin="anonymous"
    />

    <link href="<?= base_url('assets/css/main.css'); ?>" rel="stylesheet" />
  </head>

  <body class="<?= $page_class ?? 'index-page'; ?>">
    <header id="header" class="header sticky-top">
      <div class="header-top">
        <div class="container-fluid container-xl">
          <div class="row align-items-center g-3">
            <div class="col-12 col-lg-6">
              <div class="header-brand d-flex align-items-center">
                <img
                  src="<?= base_url('assets/img/ponpes.webp'); ?>"
                  alt="Logo Pondok Pesantren Sirojan Muniro As-Salam"
                  class="me-1"
                  decoding="async"
                />
                <div class="brand-text">
                  <h2 class="mb-1 text-white text-uppercase">Pondok Pesantren</h2>
                  <h4 class="text-uppercase mb-0">Sirojan Muniro As-Salam</h4>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6">
              <div class="header-socials-wrapper d-flex justify-content-lg-end justify-content-center">
                <div class="header-socials">
                  <a
                    class="instagram"
                    href="https://www.instagram.com/sirojanmuniro_assalam?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                    aria-label="Instagram"
                  >
                    <i class="bi bi-instagram"></i>
                  </a>
                  <a
                    class="facebook"
                    href="https://www.facebook.com/Sirojanmuniroassalam"
                    aria-label="Facebook"
                  >
                    <i class="bi bi-facebook"></i>
                  </a>
                  <a class="tiktok" href="#" aria-label="TikTok">
                    <i class="bi bi-tiktok"></i>
                  </a>
                  <a
                    class="youtube"
                    href="https://www.youtube.com/channel/UChBvBOlAoq2YFPdHjWnSjNA"
                    aria-label="YouTube"
                  >
                    <i class="bi bi-youtube"></i>
                  </a>
                  <a
                    class="whatsapp"
                    href="https://wa.me/6281329039527"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="WhatsApp"
                  >
                    <i class="bi bi-whatsapp"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>