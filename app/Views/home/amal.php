<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

<main class="main" id="main-content" role="main">
  <article class="page-article" itemscope itemtype="https://schema.org/WebPage">
    <div class="page-title">
      <div class="heading py-5 bg-light">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              <h1 class="heading-title fw-bold mb-3" itemprop="headline" data-aos="fade-up">Amal</h1>
              <p class="mb-0 text-muted" itemprop="description" data-aos="fade-up" data-aos-delay="100">
                Mari berpartisipasi dalam program sosial dan pembangunan Pondok Pesantren Sirojan Muniro As-Salam.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="section">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Program Amal</h2>
          <p>Penyaluran infaq dan donasi untuk kemaslahatan umat</p>
        </div>

        <div class="row g-4">
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3">
                  <div class="icon-box flex-shrink-0">
                    <i class="bi bi-heart-fill text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">Santunan Anak Yatim</h3>
                    <p class="text-muted mb-0">
                      Program santunan untuk membantu kebutuhan pendidikan, kesehatan, dan keseharian anak yatim melalui
                      dukungan rutin maupun insidental.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3">
                  <div class="icon-box flex-shrink-0">
                    <i class="bi bi-building text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">Pembangunan Pondok</h3>
                    <p class="text-muted mb-0">
                      Program pembangunan sarana dan prasarana pondok untuk meningkatkan kenyamanan belajar, kegiatan
                      ibadah, dan pembinaan santri.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section bg-light">
      <div class="container" data-aos="fade-up">
        <div class="row justify-content-center text-center">
          <div class="col-lg-8">
            <h2 class="fw-bold mb-3">Ingin Menyalurkan Amal?</h2>
            <p class="text-muted mb-4">
              Silakan hubungi kami untuk informasi penyaluran infaq, donasi, atau kerja sama program sosial.
            </p>
            <a
              class="btn btn-success px-4 py-2"
              href="https://wa.me/6281329039527"
              target="_blank"
              rel="noopener noreferrer"
            >
              Hubungi via WhatsApp
            </a>
          </div>
        </div>
      </div>
    </section>
  </article>
</main>

<?= $this->include('templates/footer_public') ?>
