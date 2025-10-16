<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <?php
    $siteName = 'Pondok Pesantren Sirojan Muniro As-Salam';
    $pageTitle = $title ?? $siteName;
    $uri = service('uri');
    $canonical = base_url($uri?->getPath() ?? '');
    $defaultDescription = 'Website resmi Pondok Pesantren Sirojan Muniro As-Salam. Pendidikan Islam terpadu, informasi kegiatan, kajian terbaru, dan layanan pendidikan di lingkungan pesantren.';
    $metaDescription = isset($metaDescription) && is_string($metaDescription) && trim($metaDescription) !== ''
      ? $metaDescription
      : $defaultDescription;
    $defaultOgImage = base_url('assets/img/ponpes.webp');
    $ogImage = isset($ogImage) && is_string($ogImage) && trim($ogImage) !== ''
      ? $ogImage
      : $defaultOgImage;
    $ogUrl = $canonical;
    ?>
    <title><?= esc($pageTitle) ?></title>
    <link rel="canonical" href="<?= esc($canonical) ?>" />
    <meta name="description" content="<?= esc($metaDescription) ?>" />
    <meta name="robots" content="index, follow" />
    <meta name="author" content="<?= esc($siteName) ?>" />
    <meta name="theme-color" content="#0a7a31" />

    <!-- Open Graph -->
    <meta property="og:title" content="<?= esc($pageTitle) ?>" />
    <meta property="og:description" content="<?= esc($metaDescription) ?>" />
    <meta property="og:image" content="<?= esc($ogImage) ?>" />
    <meta property="og:url" content="<?= esc($ogUrl) ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="<?= esc($siteName) ?>" />
    <meta property="og:locale" content="id_ID" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="<?= esc($pageTitle) ?>" />
    <meta name="twitter:description" content="<?= esc($metaDescription) ?>" />
    <meta name="twitter:image" content="<?= esc($ogImage) ?>" />

    <link href="<?= base_url('assets/img/ponpes.ico'); ?>" rel="icon" />
    <link href="<?= base_url('assets/img/apple.ico'); ?>" rel="apple-touch-icon" />

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

    <link href="<?= base_url('assets/css/main.css?v=' . time()) ?>" rel="stylesheet" />

    <!-- Structured Data -->
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= esc($siteName) ?>",
        "url": "<?= esc(base_url()) ?>",
        "logo": "<?= esc(base_url('assets/img/favicon.png')) ?>",
        "sameAs": [
          "https://www.youtube.com/@ustadmbois"
        ]
      }
    </script>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?= esc($siteName) ?>",
        "url": "<?= esc(base_url()) ?>"
      }
    </script>
  </head>