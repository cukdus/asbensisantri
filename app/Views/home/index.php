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
                <h3>98% Lulusan Berhasil</h3>
                <p>
                  Santri kami berhasil melanjutkan ke perguruan tinggi dan
                  berkarir dengan bekal ilmu agama yang kuat.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="highlight-item">
                <div class="icon">
                  <i class="bi bi-people-fill"></i>
                </div>
                <h3>Rasio Santri-Ustadz 16:1</h3>
                <p>
                  Pembelajaran personal dengan bimbingan intensif dari para
                  ustadz berpengalaman.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="highlight-item">
                <div class="icon">
                  <i class="bi bi-globe-americas"></i>
                </div>
                <h3>Komunitas Alumni Global</h3>
                <p>
                  Jaringan alumni yang tersebar di berbagai negara dan berperan
                  aktif di masyarakat.
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
                <h3>Empowering Minds, Shaping Futures</h3>
                <p>
                  For over three decades, we have been committed to providing
                  exceptional education that prepares students for success in an
                  ever-changing world. Our innovative approach combines
                  traditional academic excellence with cutting-edge technology
                  and personalized learning experiences.
                </p>

                <div class="stats-row">
                  <div class="stat-item">
                    <div class="number">15,000+</div>
                    <div class="label">Students Enrolled</div>
                  </div>
                  <div class="stat-item">
                    <div class="number">98%</div>
                    <div class="label">Graduation Rate</div>
                  </div>
                  <div class="stat-item">
                    <div class="number">250+</div>
                    <div class="label">Expert Faculty</div>
                  </div>
                </div>

                <div class="mission-statement">
                  <p>
                    <em
                      >"Our mission is to foster intellectual curiosity,
                      critical thinking, and lifelong learning while nurturing
                      compassionate leaders who will positively impact their
                      communities and the world."</em
                    >
                  </p>
                </div>

                <a href="about.html" class="btn-learn-more">
                  Learn More About Us
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
                <div class="experience-badge">
                  <div class="years">32+</div>
                  <div class="text">Years of Excellence</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /About Section -->

      <!-- Students Life Block Section -->
      <section id="students-life-block" class="students-life-block section">
        <div class="container section-title">
          <h2>Students Life</h2>
          <p>
            Necessitatibus eius consequatur ex aliquid fuga eum quidem sint
            consectetur velit
          </p>
        </div>
        
        <div class="container">
          <div class="row align-items-center g-5">
            <div class="col-lg-6">
              <div class="content-wrapper">
                <div class="section-tag">Student Life</div>
                <h2>
                  Excepteur sint occaecat cupidatat non proident sunt in culpa
                </h2>
                <p class="description">
                  Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                  accusantium doloremque laudantium, totam rem aperiam eaque
                  ipsa.
                </p>

                <div class="stats-row">
                  <div class="stat-item">
                    <span class="stat-number">85+</span>
                    <span class="stat-label">Student Organizations</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-number">150+</span>
                    <span class="stat-label">Annual Events</span>
                  </div>
                </div>

                <div class="action-links">
                  <a href="student-life.html" class="primary-link"
                    >Explore Student Life</a
                  >
                </div>
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
                    <div class="visual-caption">
                      <span>Student Activities</span>
                    </div>
                  </div>

                  <div class="small-visual">
                    <img
                      src="<?= base_url('assets/img/education/program3.webp'); ?>"
                      alt="Academic Excellence"
                      class="img-fluid"
                    />
                    <div class="visual-caption">
                      <span>Academic Excellence</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="highlights-section">
            <div class="row g-4">
              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/activities-7.webp'); ?>"
                      alt="Leadership Programs"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Leadership Development</h5>
                    <p>
                      Nemo enim ipsam voluptatem quia voluptas sit aspernatur
                      aut odit aut fugit sed
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/activities-9.webp'); ?>"
                      alt="Cultural Events"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Cultural Diversity</h5>
                    <p>
                      Ut enim ad minima veniam quis nostrum exercitationem ullam
                      corporis suscipit
                    </p>
                  </div>
                </div>
              </div>

              <div class="col-lg-4">
                <div class="highlight-card">
                  <div class="highlight-image">
                    <img
                      src="<?= base_url('assets/img/education/activities-3.webp'); ?>"
                      alt="Innovation Hub"
                      class="img-fluid"
                    />
                  </div>
                  <div class="highlight-content">
                    <h5>Innovation Hub</h5>
                    <p>
                      Quis autem vel eum iure reprehenderit qui in ea voluptate
                      velit esse quam
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Students Life Block Section -->

      

      <!-- Call To Action Section -->
      <section
        id="call-to-action"
        class="call-to-action section light-background"
      >
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-5">
              <div class="content-wrapper">
                <div class="badge">
                  <i class="bi bi-mortarboard-fill"></i>
                  <span>Premium Education</span>
                </div>

                <h2>
                  Elevate Your Learning Journey with World-Class Education
                </h2>

                <p>
                  Discover unlimited potential through our carefully curated
                  learning experiences designed by industry leaders and
                  educational experts.
                </p>

                <div class="highlight-stats">
                  <div class="stat-group">
                    <div class="stat-item">
                      <span
                        class="number purecounter"
                        data-purecounter-start="0"
                        data-purecounter-end="25000"
                        data-purecounter-duration="2"
                        >0</span
                      >
                      <span class="label">Active Learners</span>
                    </div>
                    <div class="stat-item">
                      <span
                        class="number purecounter"
                        data-purecounter-start="0"
                        data-purecounter-end="200"
                        data-purecounter-duration="2"
                        >0</span
                      >
                      <span class="label">Expert Courses</span>
                    </div>
                  </div>
                </div>

                <div class="action-buttons">
                  <a href="programs.html" class="btn-primary"
                    >Explore Programs</a
                  >
                  <a href="trial.html" class="btn-secondary">
                    <span>Start Free Trial</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-lg-7">
              <div class="visual-section">
                <div class="main-image-container">
                  <img
                    src="<?= base_url('assets/img/education/students-1.webp'); ?>"
                    alt="Students Learning"
                    class="main-image"
                  />
                  <div class="overlay-gradient"></div>
                </div>

                <div class="feature-cards">
                  <div class="feature-card achievement">
                    <div class="icon">
                      <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="content">
                      <h4>Certified Excellence</h4>
                      <p>Industry-recognized certificates</p>
                    </div>
                  </div>

                  <div class="feature-card flexibility">
                    <div class="icon">
                      <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="content">
                      <h4>Learn at Your Pace</h4>
                      <p>24/7 access to all materials</p>
                    </div>
                  </div>

                  <div class="feature-card community">
                    <div class="icon">
                      <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="content">
                      <h4>Global Community</h4>
                      <p>Connect with learners worldwide</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- /Call To Action Section -->



      <!-- YouTube Channel Section -->
      <section id="youtube-channel" class="events section">
        <div class="container section-title">
          <h2>YouTube Channel</h2>
          <p>Simak empat kajian terbaru dari Ustadz Mbois langsung dari channel resminya.</p>
        </div>

        <div class="container">
          <div class="row g-4">
            <div class="col-lg-6">
              <div class="event-card">
                <div class="event-date">
                  <span class="month">EP</span>
                  <span class="day">42</span>
                  <span class="year">Series</span>
                </div>
                <div class="event-content">
                  <div class="video-thumb">
                    <a
                      href="https://www.youtube.com/watch?v=C7C_0dCnLMc"
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label="Tonton Eps 42"
                    >
                      <img
                        src="https://img.youtube.com/vi/C7C_0dCnLMc/hqdefault.jpg"
                        alt="Eps 42 : Ngaji Quran Surat Al Baqarah 111 - 113 Tafsir Kitab Al Jalalain"
                        class="img-fluid"
                      />
                      <span class="play-icon"><i class="bi bi-play-circle-fill"></i></span>
                    </a>
                  </div>
                  
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="event-card">
                <div class="event-date">
                  <span class="month">EP</span>
                  <span class="day">41</span>
                  <span class="year">Series</span>
                </div>
                <div class="event-content">
                  <div class="video-thumb">
                    <a
                      href="https://www.youtube.com/watch?v=BGWz-1DT4Ao"
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label="Tonton Eps 41"
                    >
                      <img
                        src="https://img.youtube.com/vi/BGWz-1DT4Ao/hqdefault.jpg"
                        alt="Eps 41 : Kajian Quran Surat Al Baqarah 109 - 110 Tafsir Kitab Jalalain"
                        class="img-fluid"
                      />
                      <span class="play-icon"><i class="bi bi-play-circle-fill"></i></span>
                    </a>
                  </div>
                  
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="event-card">
                <div class="event-date">
                  <span class="month">EP</span>
                  <span class="day">40</span>
                  <span class="year">Series</span>
                </div>
                <div class="event-content">
                  <div class="video-thumb">
                    <a
                      href="https://www.youtube.com/watch?v=jPbJ6Trsf1g"
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label="Tonton Eps 40"
                    >
                      <img
                        src="https://img.youtube.com/vi/jPbJ6Trsf1g/hqdefault.jpg"
                        alt="Eps 40 : Kajian Quran Surat Al Baqarah Ayat 106 - 108 dari Tafsir Kitab Jalalain"
                        class="img-fluid"
                      />
                      <span class="play-icon"><i class="bi bi-play-circle-fill"></i></span>
                    </a>
                  </div>
                  
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="event-card">
                <div class="event-date">
                  <span class="month">EP</span>
                  <span class="day">39</span>
                  <span class="year">Series</span>
                </div>
                <div class="event-content">
                  <div class="video-thumb">
                    <a
                      href="https://www.youtube.com/watch?v=qqVTw93OGnI"
                      target="_blank"
                      rel="noopener noreferrer"
                      aria-label="Tonton Eps 39"
                    >
                      <img
                        src="https://img.youtube.com/vi/qqVTw93OGnI/hqdefault.jpg"
                        alt="Eps 39 : Ngaji Surat Al Baqarah Ayat 104 - 105 Tafsir Kitab Al Jalalain"
                        class="img-fluid"
                      />
                      <span class="play-icon"><i class="bi bi-play-circle-fill"></i></span>
                    </a>
                  </div>
                  
                </div>
              </div>
            </div>
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
