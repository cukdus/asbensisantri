<?php
// Deteksi menu aktif secara otomatis bila $active_menu tidak diset oleh controller
$uri = service('uri');
$firstSegment = trim($uri->getSegment(1) ?? '');
// Mapping segmen pertama ke nama menu
$autoActive = $firstSegment === '' ? 'home' : $firstSegment;
// Prioritaskan nilai dari controller jika ada, jika tidak pakai deteksi otomatis
$active_menu = ($active_menu ?? $autoActive);
?>
<div class="header-bottom">
  <div class="container-fluid container-xl position-relative">
    <nav
      id="navmenu"
      class="navmenu d-flex align-items-center justify-content-between justify-content-xl-center"
    >
      <ul>
        <li><a href="<?= base_url(); ?>" class="<?= $active_menu === 'home' ? 'active' : ''; ?>">Beranda</a></li>
        <li><a href="<?= base_url('about'); ?>" class="<?= $active_menu === 'about' ? 'active' : ''; ?>">Tentang Kami</a></li>
        <li><a href="<?= base_url('quran'); ?>" class="<?= $active_menu === 'quran' ? 'active' : ''; ?>">Al-Qur'an</a></li>
        <li><a href="<?= base_url('nilai'); ?>" class="<?= $active_menu === 'nilai' ? 'active' : ''; ?>">Cek Nilai</a></li>
        <li><a href="<?= base_url('contact'); ?>" class="<?= $active_menu === 'contact' ? 'active' : ''; ?>">Kontak Kami</a></li>
      </ul>
      <button
        type="button"
        class="mobile-nav-trigger d-xl-none ms-auto d-flex align-items-center"
      >
        <span class="mobile-nav-label me-2">Menu</span>
        <i class="mobile-nav-toggle bi bi-list" aria-hidden="true"></i>
      </button>
    </nav>
  </div>
</div>

<a
  href="https://wa.me/6285731397860"
  target="_blank"
  rel="noopener noreferrer"
  class="wa-float"
  aria-label="Hubungi kami via WhatsApp"
>
  <i class="fab fa-whatsapp"></i>
</a>