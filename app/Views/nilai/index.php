<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

    <main id="main">
        <section id="students-life-block" class="students-life-block section">
        <div class="container section-title">
          <h2>Cek Nilai Siswa</h2>
          <p>
            Dengan memasukkan NIS (Nomor Induk Siswa) yang terdaftar, Anda dapat melihat nilai yang telah diberikan oleh guru.
          </p>
        </div>
        
        <div class="container">
          <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm rounded-4">
                            <div class="card-body p-4">
                                <h4 class="card-title text-center mb-4">Cek Nilai Siswa</h4>
                                
                                <?php if (session()->has('error')): ?>
                                    <div class="alert alert-danger">
                                        <?= session('error'); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if (session()->has('errors')): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach (session('errors') as $error): ?>
                                                <li><?= $error; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('nilai/cek'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <div class="form-group mb-3">
                                        <label for="nis" class="form-label">Nomor Induk Siswa (NIS)</label>
                                        <input type="text" class="form-control" id="nis" name="nis" placeholder="Masukkan NIS" value="<?= old('nis'); ?>" required>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success">Cek Nilai</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

          
        </div>
      </section>

        
    </main>

    <?= $this->include('templates/footer_public') ?>
</body>
</html>