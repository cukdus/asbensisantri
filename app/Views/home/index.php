<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

    <main class="main">
      <section id="hero" class="hero section" aria-labelledby="hero-heading">
        <div class="hero-container">
          <div class="hero-content">
            <h1 class="hero-title" id="hero-heading" itemprop="headline">
              <span>Pondok Pesantren</span>
              <span class="hero-title-highlight">Sirojan Muniro As-Salam</span>
            </h1>
            <p itemprop="description">
              Mencetak generasi Qur'ani, berakhlak mulia, dan siap mengabdi
              untuk umat.
            </p>
          </div>
        </div>
        <div class="highlights-container container mb-5">
          <div class="row gy-4">
            <div class="col-md-4">
              <div class="highlight-item">
                <div class="icon">
                  <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3>Ngaji Iqro'</h3>
                <p>
                  Pembelajaran dasar huruf hijaiyah dengan metode bertahap agar santri lancar membaca Al-Qur'an dengan tartil.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="highlight-item">
                <div class="icon">
                  <i class="bi bi-people-fill"></i>
                </div>
                <h3>Ngaji Al-Qur'an</h3>
                <p>
                  Bimbingan intensif memperbaiki bacaan dan tajwid, menumbuhkan kecintaan serta kedekatan santri dengan Al-Qur'an.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="highlight-item">
                <div class="icon">
                  <i class="bi bi-globe-americas"></i>
                </div>
                <h3>Kajian Kitab Kuning</h3>
                <p>
                  Pendalaman ilmu agama melalui kitab Nahwu, Shorof, Aqidatu Awam, dan Ta'limul Muta'allim sebagai fondasi keilmuan dan akhlak santri.
                </p>
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
                <h3>Memberdayakan Jiwa, Membentuk Masa Depan Islami</h3>
                <p>
                  kami berkomitmen menghadirkan pendidikan Islam yang menanamkan nilai ilmu, adab, dan kecintaan kepada Al-Qur'an. Melalui program unggulan seperti ngaji Iqro', ngaji Al-Qur'an, kajian kitab Nahwu & Shorof, ngaji dan hafalan Aqidatu Awam, serta Ta'limul Muta'allim, santri dibimbing menjadi pribadi berilmu dan berakhlak. Dilengkapi dengan ekstrakurikuler Al-Banjari dan rutinan majlis ngaji serta sholawat setiap malam Jum'at, kami berupaya mencetak generasi yang beriman, beradab, dan berjiwa islami yang siap mengabdi untuk agama dan masyarakat.
                </p>

                <div class="mission-statement">
                  <p>
                    <em>"Misi kami adalah <b>menuntun santri menjadi pribadi beradab dan berakhlak mulia</b> berlandaskan Al-Qur’an dan hadits, serta <b>mendidik mereka menjadi insan yang bermanfaat bagi umat</b> melalui ilmu, amal, dan keterampilan. Kami berkomitmen untuk <b>memanusiakan manusia dengan menanamkan nilai kasih sayang universal</b>, tanpa membeda-bedakan suku, agama, ras, maupun golongan. Selain itu, kami berupaya <b>membumikan sholawat</b> dengan menumbuhkan cinta kepada Rasulullah ﷺ melalui majlis sholawat dan keteladanan akhlak Nabi yang mulia."</em>
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
                <img
                  src="<?= base_url('assets/img/education/about.webp'); ?>"
                  alt="Campus Overview"
                  class="img-fluid"
                />
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /About Section -->
<!-- Featured Programs Section -->
  <section id="featured-programs" class="featured-programs section">
    <!-- Section Title -->
    <div class="container section-title">
      <h2>Program Unggulan</h2>
      <p>Program-program pendidikan yang dirancang khusus untuk membentuk santri yang beriman, bertakwa, dan berilmu</p>
    </div><!-- End Section Title -->

    <div class="container">
      <div class="featured-programs-wrapper">
        <div class="programs-overview">
          <div class="overview-content">
            <h2>Keunggulan Pendidikan Islam</h2>
            <p>Keunggulan Pendidikan Islam terletak pada keseimbangan antara ilmu, adab, dan spiritualitas. Melalui <b>ngaji Iqro’ dan Al-Qur’an</b>, santri dibimbing untuk membaca dan memahami kalam Allah dengan benar. <b>Ngaji Kitab Nahwu dan Shorof</b> memperkuat kemampuan bahasa Arab, sedangkan <b>ngaji serta hafalan Aqidatu Awam</b> menanamkan akidah yang kokoh. Nilai adab dan etika ditanamkan melalui <b>ngaji Ta’limul Muta’allim</b>, diiringi kegiatan <b>ekstrakurikuler Al-Banjari</b> yang menumbuhkan cinta sholawat dan kebersamaan. Semua itu dilengkapi dengan <b>rutinan majlis ngaji dan sholawat setiap malam Jum’at</b> sebagai pembiasaan ibadah dan penguatan iman santri.
</p>
          </div>
          <div class="overview-image">
            <img src="assets/img/education/edukasi1.webp" alt="Education" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
      <!-- Students Life Block Section -->
      <section id="students-life-block" class="students-life-block section">
        <div class="container section-title">
          <h2>Kehidupan Santri</h2>
          <p>
            Kehidupan yang penuh berkah dengan keseimbangan antara ibadah, belajar, dan aktivitas positif lainnya.
          </p>
        </div>
        
        <div class="container">
          <div class="row align-items-center g-5">
            <div class="col-lg-6">
              <div class="content-wrapper">
                <div class="section-tag">Kehidupan Santri</div>
                <h2>
                  Lingkungan Islami yang Mendukung Pertumbuhan Rohani dan Jasmani
                </h2>
                <p class="description">
                  Kehidupan di pondok pesantren memberikan pengalaman yang holistik dengan jadwal yang terstruktur, mulai dari shalat berjamaah, kajian kitab, ngaji, hingga kegiatan ekstrakurikuler yang menumbuhkan bakat dan minat santri.
                </p>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="visual-grid">
                <div class="main-visual">
                  <img
                    src="<?= base_url('assets/img/education/program1.webp'); ?>"
                    alt="Campus Life"
                    class="img-fluid"
                  />
                </div>

                <div class="secondary-visuals">
                  <div class="small-visual">
                    <img
                      src="<?= base_url('assets/img/education/program2.webp'); ?>"
                      alt="Student Activities"
                      class="img-fluid"
                    />
                  </div>

                  <div class="small-visual">
                    <img
                      src="<?= base_url('assets/img/education/program4.webp'); ?>"
                      alt="Academic Excellence"
                      class="img-fluid"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
<div class="container section-title mt-5">
          <h2>Kegiatan Mengaji Santri</h2>
          <p>
            Membangun generasi Qur'ani yang berakhlak mulia.
          </p>
        </div>
          <div class="highlights-section">
            <div class="row g-4">
              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/kegiatan2.webp'); ?>"
                      alt="Leadership Programs"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Ngaji Iqro'</h5>
                    <p>
                      Pembelajaran dasar membaca huruf hijaiyah untuk santri pemula agar fasih membaca Al-Qur'an.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/mengajiquran.png'); ?>"
                      alt="Cultural Events"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Ngaji Al-Qur'an</h5>
                    <p>
                      Santri memperdalam bacaan Al-Qur'an dengan tajwid yang benar serta memahami makna ayat-ayat suci.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/program5.webp'); ?>"
                      alt="Innovation Hub"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Ngaji Kitab Nahwu & Shorof</h5>
                    <p>
                      Pembelajaran tata bahasa Arab untuk memperkuat dasar pemahaman kitab kuning.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row g-4">
              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/kegiatan3.webp'); ?>"
                      alt="Leadership Programs"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Ngaji & Hafalan Aqidatu Awam</h5>
                    <p>
                      Pembelajaran Aqidah dasar disertai hafalan untuk menanamkan keyakinan Islam sejak dini.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/ngaji.webp'); ?>"
                      alt="Cultural Events"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Ngaji Ta'limul Muta'alim</h5>
                    <p>
                      Kajian adab dan tata cara menuntut ilmu berdasarkan kitab Ta'limul Muta'alim.
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/program3.webp'); ?>"
                      alt="Innovation Hub"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Ekstra Latihan Al-Banjari</h5>
                    <p>
                      Kegiatan seni musik islami dengan rebana untuk menumbuhkan semangat syiar dan cinta sholawat.
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row g-4">
              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/majlisngaji.webp'); ?>"
                      alt="Leadership Programs"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Rutinan Majlis Ngaji & Sholawat</h5>
                    <p>
                      Kegiatan rutin setiap malam Jum'at untuk memperkuat ukhuwah dan meningkatkan keimanan bersama.
                    </p>
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
