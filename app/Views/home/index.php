<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

    <main class="main">
<!-- Hero Section -->
  <section id="hero" class="hero section" aria-labelledby="hero-heading">
    <div class="hero-container">
      <div class="hero-content">
        <h1 class="hero-title" id="hero-heading" itemprop="headline">
          <span>Pondok Pesantren</span>
          <span class="hero-title-highlight">Sirojan Muniro As-Salam</span>
        </h1>
        <p itemprop="description">
          Menebar cahaya ilmu, adab, dan Al-Qur'an dalam membentuk generasi beriman, berilmu, dan berakhlak mulia.
        </p>
      </div>
    </div>

    <div class="highlights-container container mb-5">
      <div class="row gy-4">
        <div class="col-md-4">
          <div class="highlight-item">
            <div class="icon"><i class="bi bi-book-half"></i></div>
            <h3>Ngaji Iqro'</h3>
            <p>Pondasi awal pembelajaran Al-Qur'an bagi santri pemula dengan bimbingan metode yang lembut, terarah, dan penuh kasih.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="highlight-item">
            <div class="icon"><i class="bi bi-journal-text"></i></div>
            <h3>Ngaji Al-Qur'an</h3>
            <p>Program tahsin dan tahfidz Al-Qur'an untuk memperbaiki bacaan, memahami tajwid, serta menanamkan cinta terhadap kalamullah.</p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="highlight-item">
            <div class="icon"><i class="bi bi-journal-bookmark-fill"></i></div>
            <h3>Kajian Kitab Kuning</h3>
            <p>Pendalaman ilmu agama dengan kitab klasik seperti Nahwu, Shorof, Aqidatu Awam, dan Ta'limul Muta'allim sebagai pedoman adab dan ilmu.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Hero Section -->


  <!-- About Section -->
  <section id="about" class="about section">
    <div class="container">
      <div class="row gy-5">
        <div class="col-lg-6">
          <div class="content">
            <h3>Cahaya Ilmu dan Akhlak untuk Generasi Qur'ani</h3>
            <p>
              Pondok Pesantren Sirojan Muniro As-Salam berkomitmen menanamkan nilai-nilai Islam melalui pendidikan yang terpadu antara ilmu, amal, dan adab.
              Kami hadir untuk membentuk generasi Qur'ani yang beriman, berilmu, dan berakhlak mulia, serta siap mengabdi kepada umat dan bangsa.
            </p>

            <p>
              Dengan pembelajaran Al-Qur'an, kajian kitab kuning, dan pembiasaan akhlak Islami, santri dibimbing menjadi pribadi berjiwa ikhlas dan cinta ilmu.
              Kegiatan ekstrakurikuler seperti Al-Banjari dan majlis sholawat menjadi bagian dari proses pembentukan karakter yang berlandaskan cinta kepada Rasulullah ﷺ.
            </p>

            <div class="mission-statement">
              <p>
                <em>
                  “Menuntun santri menuju <b>keberkahan ilmu dan keteladanan akhlak</b> dengan menanamkan nilai kasih sayang universal serta menumbuhkan semangat dakwah yang santun dan membumi.”
                </em>
              </p>
            </div>

            <a href="about.html" class="btn-learn-more">
              Pelajari Lebih Lanjut
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="image-wrapper">
            <img src="<?= base_url('assets/img/education/about.webp'); ?>" alt="Pondok Pesantren Sirojan Muniro As-Salam" class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /About Section -->


  <!-- Featured Programs Section -->
  <section id="featured-programs" class="featured-programs section">
    <div class="container section-title">
      <h2>Program Unggulan</h2>
      <p>Pendidikan terarah untuk membangun generasi Qur'ani yang beradab, beriman, dan bermanfaat bagi masyarakat.</p>
    </div>

    <div class="container">
      <div class="featured-programs-wrapper">
        <div class="programs-overview">
          <div class="overview-content">
            <h2>Keunggulan Pendidikan di Sirojan Muniro As-Salam</h2>
            <p>
              Keunggulan pendidikan di pesantren kami terletak pada keseimbangan antara <b>ilmu agama, adab, dan praktik ibadah</b>.
              Melalui pembelajaran Iqro' dan Al-Qur'an, santri dididik untuk membaca dengan tartil dan memahami makna ayat.
              Kajian kitab Nahwu, Shorof, serta Aqidatu Awam memperkuat dasar keilmuan, sementara kitab Ta'limul Muta'allim menanamkan etika menuntut ilmu.
              Diperkuat dengan kegiatan Al-Banjari, majlis sholawat, dan pendampingan rohani, semua dirancang untuk membentuk insan yang istiqamah di jalan Allah.
            </p>
          </div>
          <div class="overview-image">
            <img src="assets/img/education/edukasi1.webp" alt="Program Pendidikan Santri" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Featured Programs Section -->


  <!-- Students Life Block Section -->
  <section id="students-life-block" class="students-life-block section">
    <div class="container section-title">
      <h2>Kehidupan Santri</h2>
      <p>Keseharian santri yang sarat nilai ibadah, kebersamaan, dan kedisiplinan sebagai bekal hidup berakhlak dan mandiri.</p>
    </div>
    
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-6">
          <div class="content-wrapper">
            <div class="section-tag">Kehidupan Santri</div>
            <h2>Lingkungan Islami yang Menumbuhkan Iman dan Akhlak</h2>
            <p class="description">
              Santri dibina dalam suasana ukhuwah dan disiplin ibadah, mengikuti kegiatan shalat berjamaah, ngaji rutin, dan pembelajaran kitab.
              Aktivitas harian juga diisi dengan kegiatan sosial, keterampilan, serta pembinaan karakter untuk menyiapkan generasi yang tangguh dan berjiwa dakwah.
            </p>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="visual-grid">
            <div class="main-visual">
              <img src="<?= base_url('assets/img/education/program1.webp'); ?>" alt="Kehidupan Santri" class="img-fluid" />
            </div>
            <div class="secondary-visuals">
              <div class="small-visual">
                <img src="<?= base_url('assets/img/education/program2.webp'); ?>" alt="Aktivitas Santri" class="img-fluid" />
              </div>
              <div class="small-visual">
                <img src="<?= base_url('assets/img/education/program4.webp'); ?>" alt="Pembelajaran Santri" class="img-fluid" />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container section-title mt-5">
        <h2>Kegiatan Mengaji Santri</h2>
        <p>Menghidupkan semangat Qur'ani dalam setiap langkah kehidupan santri.</p>
      </div>

      <div class="highlights-section">
        <div class="row g-4 mt-1">
          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/kegiatan2.webp'); ?>" alt="Ngaji Iqro'" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Ngaji Iqro'</h5>
                <p>Pembelajaran huruf hijaiyah dan dasar membaca Al-Qur'an secara bertahap dengan metode yang mudah dipahami santri pemula.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/mengajiquran.png'); ?>" alt="Ngaji Al-Qur'an" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Ngaji Al-Qur'an</h5>
                <p>Pembinaan tahsin dan tahfidz agar santri membaca dan memahami Al-Qur'an dengan tartil dan benar.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/program5.webp'); ?>" alt="Ngaji Nahwu Shorof" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Ngaji Kitab Nahwu & Shorof</h5>
                <p>Pemahaman struktur bahasa Arab melalui kitab klasik untuk memperkuat kemampuan membaca dan menafsirkan teks ilmiah keislaman.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 mt-1">
          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/kegiatan3.webp'); ?>" alt="Ngaji Aqidatu Awam" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Ngaji & Hafalan Aqidatu Awam</h5>
                <p>Penanaman aqidah yang benar melalui hafalan dan pemahaman teks klasik agar santri memiliki dasar keimanan yang kuat.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/ngaji.webp'); ?>" alt="Ngaji Ta'limul Muta'allim" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Ngaji Ta'limul Muta'allim</h5>
                <p>Menanamkan adab menuntut ilmu melalui kitab klasik Ta'limul Muta'allim agar santri berilmu sekaligus berakhlak.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/program3.webp'); ?>" alt="Al-Banjari" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Ekstra Al-Banjari</h5>
                <p>Kegiatan rebana dan sholawat sebagai wadah seni dakwah santri yang menumbuhkan semangat cinta Rasulullah ﷺ.</p>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 mt-1">
          <div class="col-lg-4">
            <div class="highlight-card shadow-lg">
              <div class="highlight-image">
                <img src="<?= base_url('assets/img/education/majlisngaji.webp'); ?>" alt="Majlis Ngaji & Sholawat" class="img-fluid" />
              </div>
              <div class="highlight-content">
                <h5>Rutinan Majlis Ngaji & Sholawat</h5>
                <p>Kegiatan rutin setiap malam Jum'at untuk mempererat ukhuwah, memperkuat iman, dan membumikan sholawat di kalangan santri dan masyarakat.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Students Life Block Section -->



      <!-- YouTube Channel Section -->
      <section id="youtube-channel" class="events section">
        <div class="container section-title">
          <h2>YouTube Channel</h2>
          <p>Simak empat kajian terbaru dari Ustadz Mbois langsung dari channel resminya.</p>
        </div>

        <div class="container">
          <div class="row g-4">
            <?php if (!empty($youtubeVideos)): ?>
              <?php foreach ($youtubeVideos as $video): ?>
                <div class="col-lg-6">
                  <div class="event-card">
                    <div class="event-date">
                      <span class="month"><?= esc(date('M', strtotime($video['publishedAt']))) ?></span>
                      <span class="day"><?= esc(date('d', strtotime($video['publishedAt']))) ?></span>
                      <span class="year"><?= esc(date('Y', strtotime($video['publishedAt']))) ?></span>
                    </div>
                    <div class="event-content">
                      <div class="video-thumb">
                        <a
                          href="https://www.youtube.com/watch?v=<?= esc($video['videoId']) ?>"
                          target="_blank"
                          rel="noopener noreferrer"
                          aria-label="<?= esc($video['title']) ?>"
                        >
                          <img
                            src="<?= esc($video['thumbnail']) ?>"
                            alt="<?= esc($video['title']) ?>"
                            class="img-fluid"
                          />
                          <span class="play-icon"><i class="bi bi-play-circle-fill"></i></span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-12">
                <div class="alert alert-warning mb-0" role="alert">
                  Tidak dapat memuat video terbaru. Silakan kunjungi channel untuk melihat konten terkini.
                </div>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="text-center mt-5">
            <a
              href="https://www.youtube.com/@ustadmbois"
              class="btn-view-all"
              target="_blank"
              rel="noopener noreferrer"
            >Kunjungi Channel</a>
          </div>
        </div>
      </section>
      <!-- /YouTube Channel Section -->

      <!-- Supported By Section -->
      <section id="supported-by" class="supported-by section light-background">
        <div class="container section-title">
          <h2>Supported By</h2>
          <p>Kolaborasi bersama mitra terbaik yang mendukung perjalanan kami.</p>
        </div>

        <div class="container">
          <div class="partners-slider swiper init-swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 2500
                },
                "slidesPerView": 2,
                "spaceBetween": 20,
                "breakpoints": {
                  "768": {
                    "slidesPerView": 3
                  },
                  "1200": {
                    "slidesPerView": 5
                  }
                }
              }
            </script>

            <div class="swiper-wrapper" id="swiper-wrapper-85baab165fb49f85" aria-live="off" style="transition-duration: 0ms; transform: translate3d(-1052.8px, 0px, 0px); transition-delay: 0ms;">
              
            <div class="swiper-slide" role="group" aria-label="8 / 9" data-swiper-slide-index="7" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/pressolve.webp'); ?>" alt="Pressolve" class="partner-logo">
                </div>
              </div><div class="swiper-slide" role="group" aria-label="9 / 9" data-swiper-slide-index="8" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/SEH.webp'); ?>" alt="SEH" class="partner-logo">
                </div>
              </div><div class="swiper-slide" role="group" aria-label="1 / 9" data-swiper-slide-index="0" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/ais.webp'); ?>" alt="AIS" class="partner-logo">
                </div>
              </div><div class="swiper-slide swiper-slide-prev" role="group" aria-label="2 / 9" data-swiper-slide-index="1" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/atourwis.webp'); ?>" alt="Atour Wisata" class="partner-logo">
                </div>
              </div><div class="swiper-slide swiper-slide-active" role="group" aria-label="3 / 9" data-swiper-slide-index="2" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/bekasbaru.webp'); ?>" alt="Bekas Baru" class="partner-logo">
                </div>
              </div><div class="swiper-slide swiper-slide-next" role="group" aria-label="4 / 9" data-swiper-slide-index="3" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/eqiyu.webp'); ?>" alt="Eqiyu" class="partner-logo">
                </div>
              </div><div class="swiper-slide" role="group" aria-label="5 / 9" data-swiper-slide-index="4" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/mbowis.webp'); ?>" alt="Mbowis" class="partner-logo">
                </div>
              </div><div class="swiper-slide" role="group" aria-label="6 / 9" data-swiper-slide-index="5" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/mlg.webp'); ?>" alt="MLG" class="partner-logo">
                </div>
              </div><div class="swiper-slide" role="group" aria-label="7 / 9" data-swiper-slide-index="6" style="width: 243.2px; margin-right: 20px;">
                <div class="partner-card">
                  <img src="<?= base_url('assets/img/supported/overhaul.webp'); ?>" alt="Overhaul" class="partner-logo">
                </div>
              </div></div>

            <div class="swiper-pagination"></div>
          <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
        </div>
      </section>
      <!-- /Supported By Section -->
    </main>

<?= $this->include('templates/footer_public') ?>
