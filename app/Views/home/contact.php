<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

<main class="main" id="main-content" role="main">
    <article class="page-article" itemscope itemtype="https://schema.org/ContactPage">
      <div class="page-title">
        <div class="heading">
          <div class="container">
            <div class="row d-flex justify-content-center text-center">
              <div class="col-lg-8">
                <h1 class="heading-title" itemprop="headline">
                  Hubungi Pondok Pesantren<br />Sirojan Muniro As-Salam
                </h1>
                <p class="mb-0" itemprop="description">
                  Kami siap membantu Anda mendapatkan informasi pendaftaran, layanan santri, dan kegiatan pesantren.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="page-content" itemprop="mainEntity" itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="Pondok Pesantren Sirojan Muniro As-Salam" />
        <meta itemprop="url" content="https://sirojanmuniroassalam.com/" />

        <section id="contact-info" class="section light-background" aria-labelledby="contact-section-heading">
          <div class="container">
            <div class="section-title">
              <h2 id="contact-section-heading">Hubungi Kami</h2>
              <p>Pilih cara termudah untuk terhubung dengan kami</p>
            </div>

            <div class="row gy-4">
              <div class="col-md-6 col-lg-3">
                <div
                  class="card h-100 border-0 shadow-sm text-center py-4 position-relative"
                  itemprop="contactPoint"
                  itemscope
                  itemtype="https://schema.org/ContactPoint"
                >
                  <div class="card-body">
                    <div class="mb-3">
                      <i class="fab fa-instagram text-success display-6" aria-hidden="true"></i>
                    </div>
                    <h5 class="card-title">Instagram</h5>
                    <p class="card-text text-muted mb-0">DM langsung di akun resmi</p>
                    <a
                      href="https://www.instagram.com/sirojanmuniro_assalam"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="stretched-link"
                      aria-label="Instagram Pondok Pesantren"
                      itemprop="url"
                    ></a>
                    <meta itemprop="contactType" content="Social Media" />
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-3">
                <div
                  class="card h-100 border-0 shadow-sm text-center py-4 position-relative"
                  itemprop="contactPoint"
                  itemscope
                  itemtype="https://schema.org/ContactPoint"
                >
                  <div class="card-body">
                    <div class="mb-3">
                      <i class="fab fa-facebook-f text-success display-6" aria-hidden="true"></i>
                    </div>
                    <h5 class="card-title">Facebook</h5>
                    <p class="card-text text-muted mb-0">Ikuti dan kirim pesan</p>
                    <a
                      href="https://www.facebook.com/Sirojanmuniroassalam"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="stretched-link"
                      aria-label="Facebook Pondok Pesantren"
                      itemprop="url"
                    ></a>
                    <meta itemprop="contactType" content="Social Media" />
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-3">
                <div
                  class="card h-100 border-0 shadow-sm text-center py-4 position-relative"
                  itemprop="contactPoint"
                  itemscope
                  itemtype="https://schema.org/ContactPoint"
                >
                  <div class="card-body">
                    <div class="mb-3">
                      <i class="fab fa-youtube text-success display-6" aria-hidden="true"></i>
                    </div>
                    <h5 class="card-title">YouTube</h5>
                    <p class="card-text text-muted mb-0">Tonton dan komentar video kami</p>
                    <a
                      href="https://www.youtube.com/channel/UChBvBOlAoq2YFPdHjWnSjNA"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="stretched-link"
                      aria-label="YouTube Pondok Pesantren"
                      itemprop="url"
                    ></a>
                    <meta itemprop="contactType" content="Video Channel" />
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-lg-3">
                <div
                  class="card h-100 border-0 shadow-sm text-center py-4 position-relative"
                  itemprop="contactPoint"
                  itemscope
                  itemtype="https://schema.org/ContactPoint"
                >
                  <div class="card-body">
                    <div class="mb-3">
                      <i class="fab fa-whatsapp text-success display-6" aria-hidden="true"></i>
                    </div>
                    <h5 class="card-title">WhatsApp</h5>
                    <p class="card-text text-muted mb-0">Kirim pesan cepat</p>
                    <a
                      href="https://wa.me/085731397860"
                      target="_blank"
                      rel="noopener noreferrer"
                      class="stretched-link"
                      aria-label="WhatsApp Pondok Pesantren"
                      itemprop="url"
                    ></a>
                    <meta itemprop="contactType" content="Customer Support" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </article>
  </main>

<?= $this->include('templates/footer_public') ?>