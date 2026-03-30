<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

<?php
$donationTargets = [
  ['value' => 'tpq', 'label' => 'TPQ'],
  ['value' => 'yatim', 'label' => 'Santunan Anak Yatim'],
  ['value' => 'beasiswa', 'label' => 'Bea Siswa Pendidikan Santri'],
  ['value' => 'sembako', 'label' => 'Sembako Warga Pra Sejahtera'],
  ['value' => 'pembangunan', 'label' => 'Pembangunan Pondok Pesantren'],
  ['value' => 'pelatihan', 'label' => 'Pelatihan Ketrampilan Usaha Kecil'],
];

$qrisImageUrl = base_url('assets/img/qris.png');
$transferAccounts = [
  [
    'bank' => 'BCA',
    'number' => '1234567890',
    'name' => 'Pondok Pesantren Sirojan Muniro As-Salam',
  ],
  [
    'bank' => 'BRI',
    'number' => '0987654321',
    'name' => 'Pondok Pesantren Sirojan Muniro As-Salam',
  ],
];
?>

<style>
  #amalPaymentTabs {
    border-bottom: 0;
    gap: 0.5rem;
  }

  #amalPaymentTabs .nav-link {
    font-size: 1.1rem;
    font-weight: 700;
    padding: 0.9rem 1.75rem;
    border: 1px solid rgba(var(--bs-success-rgb), 0.35);
    border-bottom: 0;
    border-top-left-radius: 0.75rem;
    border-top-right-radius: 0.75rem;
    color: var(--bs-success);
    background: #fff;
  }

  #amalPaymentTabs .nav-link:hover {
    background: rgba(var(--bs-success-rgb), 0.08);
  }

  #amalPaymentTabs .nav-link.active {
    background: var(--bs-success);
    border-color: var(--bs-success);
    color: #fff;
  }

  #amalPaymentTabs .nav-link i {
    font-size: 1.15em;
    line-height: 1;
  }
</style>

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
                    <i class="bi bi-book text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">TPQ</h3>
                    <p class="text-muted mb-0">
                      Penyediaan kitab, alat tulis, dan perlengkapan belajar untuk mendukung kegiatan TPQ dan pembelajaran dasar Al-Qur'an.
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
        </div>

        <div class="row g-4 mt-1">
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3">
                  <div class="icon-box flex-shrink-0">
                    <i class="bi bi-award text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">Bea Siswa Pendidikan Santri</h3>
                    <p class="text-muted mb-0">
                      Dukungan biaya pendidikan bagi santri berprestasi dan yang membutuhkan agar tetap bisa belajar dengan tenang.
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
                    <i class="bi bi-basket text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">Sembako Warga Pra Sejahtera</h3>
                    <p class="text-muted mb-0">
                      Penyaluran paket kebutuhan pokok kepada warga pra sejahtera untuk meringankan beban hidup sehari-hari.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row g-4 mt-1">
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-body p-4">
                <div class="d-flex align-items-start gap-3">
                  <div class="icon-box flex-shrink-0">
                    <i class="bi bi-building text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">Pembangunan Pondok Pesantren</h3>
                    <p class="text-muted mb-0">
                      Program pembangunan sarana dan prasarana pondok untuk meningkatkan kenyamanan belajar, kegiatan
                      ibadah, dan pembinaan santri.
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
                    <i class="bi bi-tools text-success fs-2" aria-hidden="true"></i>
                  </div>
                  <div>
                    <h3 class="h5 fw-bold mb-2">Pelatihan Ketrampilan Usaha Kecil</h3>
                    <p class="text-muted mb-0">
                      Pelatihan dasar keterampilan usaha kecil untuk meningkatkan kemandirian ekonomi keluarga dan pemberdayaan masyarakat.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>Salurkan Amal</h2>
          <p>Pilih metode pembayaran, tujuan amal, dan nominal donasi</p>
        </div>

        <ul class="nav nav-tabs justify-content-center" id="amalPaymentTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active d-flex align-items-center justify-content-center gap-2"
              id="amal-qris-tab"
              data-bs-toggle="tab"
              data-bs-target="#amal-qris"
              type="button"
              role="tab"
              aria-controls="amal-qris"
              aria-selected="true"
            >
              <i class="bi bi-qr-code" aria-hidden="true"></i>
              <span>QRIS</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link d-flex align-items-center justify-content-center gap-2"
              id="amal-transfer-tab"
              data-bs-toggle="tab"
              data-bs-target="#amal-transfer"
              type="button"
              role="tab"
              aria-controls="amal-transfer"
              aria-selected="false"
            >
              <i class="bi bi-bank" aria-hidden="true"></i>
              <span>Transfer</span>
            </button>
          </li>
        </ul>

        <div class="tab-content border border-top-1 rounded p-4 shadow-sm" id="amalPaymentTabsContent">
          <div class="tab-pane fade show active" id="amal-qris" role="tabpanel" aria-labelledby="amal-qris-tab" tabindex="0">
            <div class="row g-4 align-items-start">
              <div class="col-lg-6">
                <div class="card border-0 bg-light h-100">
                  <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-3">Donasi via QRIS</h3>

                    <div class="mb-3">
                      <label class="form-label fw-semibold" for="qrisTarget">Tujuan Amal</label>
                      <select class="form-select" id="qrisTarget">
                        <option value="" selected disabled>Pilih tujuan amal</option>
                        <?php foreach ($donationTargets as $target): ?>
                          <option value="<?= esc($target['value']) ?>"><?= esc($target['label']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <div class="fw-semibold mb-2">Nominal</div>
                      <div class="d-flex flex-wrap gap-2">
                        <input class="btn-check" type="radio" name="qrisAmount" id="qrisAmount25000" value="25000" autocomplete="off" />
                        <label class="btn btn-outline-success" for="qrisAmount25000">Rp 25.000</label>

                        <input class="btn-check" type="radio" name="qrisAmount" id="qrisAmount50000" value="50000" autocomplete="off" />
                        <label class="btn btn-outline-success" for="qrisAmount50000">Rp 50.000</label>

                        <input class="btn-check" type="radio" name="qrisAmount" id="qrisAmount100000" value="100000" autocomplete="off" />
                        <label class="btn btn-outline-success" for="qrisAmount100000">Rp 100.000</label>

                        <input class="btn-check" type="radio" name="qrisAmount" id="qrisAmountOther" value="other" autocomplete="off" />
                        <label class="btn btn-outline-success" for="qrisAmountOther">Nominal lainnya</label>
                      </div>
                      <div class="mt-3 d-none" id="qrisOtherAmountWrap">
                        <label class="form-label" for="qrisOtherAmount">Masukkan nominal</label>
                        <div class="input-group">
                          <span class="input-group-text">Rp</span>
                          <input class="form-control" id="qrisOtherAmount" inputmode="numeric" placeholder="Contoh: 75000" />
                        </div>
                      </div>
                    </div>

                    <div class="d-grid">
                      <button class="btn btn-success" type="button" id="qrisDonateBtn">
                        Amal
                      </button>
                    </div>

                    <div class="alert alert-danger mt-3 d-none" id="qrisError" role="alert"></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-3">QRIS</h3>
                    <div class="text-muted mb-3" id="qrisSummary">Pilih tujuan amal dan nominal, lalu klik Amal.</div>
                    <div class="text-center">
                      <img
                        src="<?= esc($qrisImageUrl) ?>"
                        alt="QRIS"
                        class="img-fluid rounded border d-none"
                        style="max-width: 320px;"
                        id="qrisImage"
                      />
                      <div class="small text-muted mt-3 d-none" id="qrisHint">
                        Buka aplikasi pembayaran Anda, pilih scan QR, lalu selesaikan pembayaran.
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="tab-pane fade" id="amal-transfer" role="tabpanel" aria-labelledby="amal-transfer-tab" tabindex="0">
            <div class="row g-4 align-items-start">
              <div class="col-lg-6">
                <div class="card border-0 bg-light h-100">
                  <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-3">Donasi via Transfer</h3>

                    <div class="mb-3">
                      <label class="form-label fw-semibold" for="transferTarget">Tujuan Amal</label>
                      <select class="form-select" id="transferTarget">
                        <option value="" selected disabled>Pilih tujuan amal</option>
                        <?php foreach ($donationTargets as $target): ?>
                          <option value="<?= esc($target['value']) ?>"><?= esc($target['label']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <div class="fw-semibold mb-2">Nominal</div>
                      <div class="d-flex flex-wrap gap-2">
                        <input class="btn-check" type="radio" name="transferAmount" id="transferAmount25000" value="25000" autocomplete="off" />
                        <label class="btn btn-outline-success" for="transferAmount25000">Rp 25.000</label>

                        <input class="btn-check" type="radio" name="transferAmount" id="transferAmount50000" value="50000" autocomplete="off" />
                        <label class="btn btn-outline-success" for="transferAmount50000">Rp 50.000</label>

                        <input class="btn-check" type="radio" name="transferAmount" id="transferAmount100000" value="100000" autocomplete="off" />
                        <label class="btn btn-outline-success" for="transferAmount100000">Rp 100.000</label>

                        <input class="btn-check" type="radio" name="transferAmount" id="transferAmountOther" value="other" autocomplete="off" />
                        <label class="btn btn-outline-success" for="transferAmountOther">Nominal lainnya</label>
                      </div>
                      <div class="mt-3 d-none" id="transferOtherAmountWrap">
                        <label class="form-label" for="transferOtherAmount">Masukkan nominal</label>
                        <div class="input-group">
                          <span class="input-group-text">Rp</span>
                          <input class="form-control" id="transferOtherAmount" inputmode="numeric" placeholder="Contoh: 75000" />
                        </div>
                      </div>
                    </div>

                    <div class="d-grid">
                      <button class="btn btn-success" type="button" id="transferDonateBtn">
                        Amal
                      </button>
                    </div>

                    <div class="alert alert-danger mt-3 d-none" id="transferError" role="alert"></div>
                  </div>
                </div>
              </div>

              <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                  <div class="card-body p-4">
                    <h3 class="h5 fw-bold mb-3">Rekening Transfer</h3>
                    <div class="text-muted mb-3" id="transferSummary">Pilih tujuan amal dan nominal, lalu klik Amal.</div>
                    <div class="d-none" id="transferAccountsWrap">
                      <?php foreach ($transferAccounts as $acc): ?>
                        <div class="border rounded p-3 mb-3">
                          <div class="fw-semibold"><?= esc($acc['bank']) ?></div>
                          <div class="fs-5 fw-bold"><?= esc($acc['number']) ?></div>
                          <div class="text-muted small">a/n <?= esc($acc['name']) ?></div>
                        </div>
                      <?php endforeach; ?>
                      <div class="small text-muted">
                        Setelah transfer, silakan konfirmasi via WhatsApp agar dapat dicatat.
                      </div>
                      <div class="mt-3">
                        <a
                          class="btn btn-outline-success w-100"
                          href="https://wa.me/6281329039527"
                          target="_blank"
                          rel="noopener noreferrer"
                        >
                          Konfirmasi via WhatsApp
                        </a>
                      </div>
                    </div>
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

<script>
  (function () {
    function formatRupiah(amount) {
      const number = Number(amount);
      if (!Number.isFinite(number) || number <= 0) return '';
      return new Intl.NumberFormat('id-ID').format(number);
    }

    function getSelectedAmount(radioName, otherWrapId, otherInputId) {
      const selected = document.querySelector('input[name="' + radioName + '"]:checked');
      if (!selected) return null;
      if (selected.value === 'other') {
        const raw = (document.getElementById(otherInputId).value || '').toString().replace(/[^\d]/g, '');
        const parsed = Number(raw);
        return Number.isFinite(parsed) && parsed > 0 ? parsed : null;
      }
      const parsed = Number(selected.value);
      return Number.isFinite(parsed) && parsed > 0 ? parsed : null;
    }

    function wireOtherAmountToggle(radioName, otherWrapId) {
      const wrap = document.getElementById(otherWrapId);
      const radios = document.querySelectorAll('input[name="' + radioName + '"]');
      radios.forEach(function (radio) {
        radio.addEventListener('change', function () {
          const isOther = radio.value === 'other' && radio.checked;
          wrap.classList.toggle('d-none', !isOther);
        });
      });
    }

    function setError(el, message) {
      el.textContent = message || '';
      el.classList.toggle('d-none', !message);
    }

    function setupQRIS() {
      const targetSelect = document.getElementById('qrisTarget');
      const errorEl = document.getElementById('qrisError');
      const donateBtn = document.getElementById('qrisDonateBtn');
      const summaryEl = document.getElementById('qrisSummary');
      const imgEl = document.getElementById('qrisImage');
      const hintEl = document.getElementById('qrisHint');

      donateBtn.addEventListener('click', function () {
        setError(errorEl, '');
        const targetText = targetSelect.options[targetSelect.selectedIndex]?.text || '';
        const amount = getSelectedAmount('qrisAmount', 'qrisOtherAmountWrap', 'qrisOtherAmount');

        if (!targetSelect.value) {
          setError(errorEl, 'Silakan pilih tujuan amal terlebih dahulu.');
          return;
        }
        if (!amount) {
          setError(errorEl, 'Silakan pilih nominal amal terlebih dahulu.');
          return;
        }

        summaryEl.textContent = 'Tujuan: ' + targetText + ' • Nominal: Rp ' + formatRupiah(amount);
        imgEl.classList.remove('d-none');
        hintEl.classList.remove('d-none');
      });
    }

    function setupTransfer() {
      const targetSelect = document.getElementById('transferTarget');
      const errorEl = document.getElementById('transferError');
      const donateBtn = document.getElementById('transferDonateBtn');
      const summaryEl = document.getElementById('transferSummary');
      const accountsWrap = document.getElementById('transferAccountsWrap');

      donateBtn.addEventListener('click', function () {
        setError(errorEl, '');
        const targetText = targetSelect.options[targetSelect.selectedIndex]?.text || '';
        const amount = getSelectedAmount('transferAmount', 'transferOtherAmountWrap', 'transferOtherAmount');

        if (!targetSelect.value) {
          setError(errorEl, 'Silakan pilih tujuan amal terlebih dahulu.');
          return;
        }
        if (!amount) {
          setError(errorEl, 'Silakan pilih nominal amal terlebih dahulu.');
          return;
        }

        summaryEl.textContent = 'Tujuan: ' + targetText + ' • Nominal: Rp ' + formatRupiah(amount);
        accountsWrap.classList.remove('d-none');
      });
    }

    wireOtherAmountToggle('qrisAmount', 'qrisOtherAmountWrap');
    wireOtherAmountToggle('transferAmount', 'transferOtherAmountWrap');
    setupQRIS();
    setupTransfer();
  })();
</script>

<?= $this->include('templates/footer_public') ?>
