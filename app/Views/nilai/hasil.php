<?= $this->include('templates/head_public') ?>
<?= $this->include('templates/header_public') ?>
<?= $this->include('templates/navbar_public') ?>

<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Nilai Siswa</h2>
                <ol>
                    <li><a href="<?= base_url(); ?>">Home</a></li>
                    <li><a href="<?= base_url('nilai'); ?>">Cek Nilai</a></li>
                    <li>Hasil</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="inner-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card shadow-sm rounded-4">
                        <div class="card-header bg-primary text-white">
                            <h4 class="card-title mb-0"><b>Nilai Siswa</b></h4>
                            <p class="card-category mb-0">
                                Siswa: <?= $siswa['nama_siswa']; ?> (<?= $siswa['nis']; ?>)
                                <?php if (isset($siswa['kelas']) && isset($siswa['jurusan'])): ?> 
                                - <?= $siswa['kelas']; ?> <?= $siswa['jurusan']; ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="card-body mx-3 my-3">
                            <!-- Info Siswa -->
                            
                            

                            <!-- Business Card Style Student Info Section -->
                  <div class="row mb-4">
                     <div class="col-md-4">
                        <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                           <div class="card-body p-3 text-center" style="background: <?= $siswa['jenis_kelamin'] == 'Perempuan' ? 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)' : 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)' ?>;">
                              <div class="photo-container mb-2" style="position: relative; display: inline-block;">
                                 <?php if (!empty($siswa['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $siswa['foto'])): ?>
                                    <img src="<?= base_url('uploads/siswa/' . $siswa['foto']); ?>" 
                                         alt="Foto <?= $siswa['nama_siswa']; ?>" 
                                         class="rounded-circle border border-white" 
                                         style="width: 200px; height: 200px; object-fit: cover; border-width: 4px !important;">
                                 <?php else: ?>
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" 
                                         style="width: 200px; height: 200px; border-width: 4px !important;">
                                       <i class="material-icons text-muted" style="font-size: 60px;">school</i>
                                    </div>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="card h-80 shadow-sm" style="border-radius: 15px;">
                           <div class="card-body">
                              <h2 class="card-title text-success mb-3">
                                 <?= $siswa['nama_siswa'] ?: 'Nama Siswa' ?>
                              </h2>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <p class="mb-2"><strong>NIS:</strong><br><span class="text-muted"><?= $siswa['nis'] ?: '-' ?></span></p>
                                    <p class="mb-2"><strong>Kelas:</strong><br><span class="text-muted"><?php if (isset($siswa['kelas']) && isset($siswa['jurusan'])): ?> 
                                - <?= $siswa['kelas']; ?> <?= $siswa['jurusan']; ?>
                                <?php endif; ?></span></p>
                                    <?php if (!empty($siswa['alamat'])): ?>
                                       <p class="mb-0"><strong>Alamat:</strong><br><span class="text-muted"><?= $siswa['alamat'] ?></span></p>
                                    <?php endif; ?>
                                 </div>
                                 <div class="col-sm-6">
                                    <p class="mb-2"><strong>No HP:</strong><br><span class="text-muted"><?= $siswa['no_hp'] ?: '-' ?></span></p>
                                    <p class="mb-2"><strong>Nama Orang Tua:</strong><br><span class="text-muted"><?= $siswa['nama_orang_tua'] ?: '-' ?></span></p>
                                    <p class="mb-2"><strong>Tahun Masuk:</strong><br><span class="text-muted"><?= $siswa['tahun_masuk'] ?: '-' ?></span></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>


                            <!-- Daftar Nilai -->
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="card-title text-success mb-3">
                                        <i class="bi bi-bar-chart-fill" style="vertical-align: middle;"></i>
                                        Daftar Nilai
                                    </h6>
                                    
                                    <?php if (!empty($nilaiList)): ?>
                                        <?php
                                        // Kelompokkan nilai berdasarkan tahun ajaran dan kelas
                                        $nilaiByYear = [];
                                        foreach ($nilaiList as $nilai) {
                                            $tahunAjaran = $nilai['tahun_ajaran'];
                                            $kelas = $nilai['kelas'] ?: 'Tidak Diketahui';

                                            if (!isset($nilaiByYear[$tahunAjaran])) {
                                                $nilaiByYear[$tahunAjaran] = [];
                                            }

                                            if (!isset($nilaiByYear[$tahunAjaran][$kelas])) {
                                                $nilaiByYear[$tahunAjaran][$kelas] = [];
                                            }
                                        }

                                        // Mengurutkan tahun ajaran dari terbaru ke terlama
                                        krsort($nilaiByYear);

                                        foreach ($nilaiByYear as $tahunAjaran => $kelasList):
                                            ?>
                                            <div class="mb-4">
                                                <h6 class="text-primary mb-3">
                                                    <i class="bi bi-calendar-check" style="vertical-align: middle;"></i>
                                                    Tahun Ajaran <?= $tahunAjaran; ?>
                                                </h6>
                                                
                                                <?php
                                                // Mengurutkan kelas
                                                ksort($kelasList);

                                                foreach ($kelasList as $kelas => $dummy):
                                                    ?>
                                                    <div class="card mb-3 border-0 shadow-sm">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0">Kelas <?= $kelas; ?></h6>
                                                        </div>
                                                        <div class="card-body">
                                                            <?php
                                                            // Semester ganjil dan genap sudah difilter di controller
                                                            ?>
                                                            
                                                            <div class="row">
                                                                <!-- Semester Ganjil -->
                                                                <div class="col-md-6 mb-3">
                                                                    <div class="card border-0 bg-light h-100" style="border-radius: 8px;">
                                                                        <div class="card-body p-3">
                                                                            <div class="d-flex align-items-center mb-3">
                                                                                <div class="bg-primary rounded-circle p-2 mr-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                                                                    <i class="bi bi-book text-white" style="font-size: 18px;"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <h6 class="mb-0 font-weight-bold text-primary">
                                                                                        Semester 1
                                                                                    </h6>
                                                                                    <small class="text-muted">Ganjil</small>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <?php
                                                                            // Filter nilai berdasarkan tahun ajaran dan kelas saat ini
                                                                            $filteredGanjil = array_filter($semesterGanjil, function ($item) use ($tahunAjaran, $kelas) {
                                                                                return $item['tahun_ajaran'] == $tahunAjaran && $item['kelas'] == $kelas;
                                                                            });

                                                                            if (!empty($filteredGanjil)):
                                                                                ?>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-sm table-borderless mb-0">
                                                                                        <tbody>
                                                                                            <?php foreach ($filteredGanjil as $nilai): ?>
                                                                                                <tr>
                                                                                                    <td class="py-1" style="width: 65%;">
                                                                                                        <small class="text-dark font-weight-medium"><?= $nilai['nama_mapel'] ?></small>
                                                                                                    </td>
                                                                                                    <td class="py-1 text-right">
                                                                                        <span class="badge rounded-pill px-2 <?= $nilai['nilai'] >= 75 ? 'bg-success' : ($nilai['nilai'] >= 60 ? 'bg-warning' : 'bg-danger') ?>">
                                                                                            <?= number_format($nilai['nilai'], 1) ?>
                                                                                        </span>
                                                                                    </td>
                                                                                    <td class="py-1 text-right">
                                                                                        <?php
                                                                                        $grade = '';
                                                                                        if ($nilai['nilai'] >= 90)
                                                                                            $grade = 'A';
                                                                                        elseif ($nilai['nilai'] >= 80)
                                                                                            $grade = 'B';
                                                                                        elseif ($nilai['nilai'] >= 70)
                                                                                            $grade = 'C';
                                                                                        elseif ($nilai['nilai'] >= 60)
                                                                                            $grade = 'D';
                                                                                        else
                                                                                            $grade = 'E';
                                                                                        ?>
                                                                                        <span class="badge rounded-pill <?= $grade == 'A' ? 'bg-success' : ($grade == 'B' ? 'bg-info' : ($grade == 'C' ? 'bg-warning' : 'bg-danger')) ?>">
                                                                                            <?= $grade; ?>
                                                                                        </span>
                                                                                    </td>
                                                                                                </tr>
                                                                                            <?php endforeach; ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            <?php else: ?>
                                                                                <div class="text-center py-3">
                                                                                    <small class="text-muted">Belum ada nilai</small>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Semester Genap -->
                                                                <div class="col-md-6 mb-3">
                                                                    <div class="card border-0 bg-light h-100" style="border-radius: 8px;">
                                                                        <div class="card-body p-3">
                                                                            <div class="d-flex align-items-center mb-3">
                                                                                <div class="bg-success rounded-circle p-2 mr-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                                                                                    <i class="bi bi-book text-white" style="font-size: 18px;"></i>
                                                                                </div>
                                                                                <div>
                                                                                    <h6 class="mb-0 font-weight-bold text-success">
                                                                                        Semester 2
                                                                                    </h6>
                                                                                    <small class="text-muted">Genap</small>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <?php
                                                                            // Filter nilai berdasarkan tahun ajaran dan kelas saat ini
                                                                            $filteredGenap = array_filter($semesterGenap, function ($item) use ($tahunAjaran, $kelas) {
                                                                                return $item['tahun_ajaran'] == $tahunAjaran && $item['kelas'] == $kelas;
                                                                            });

                                                                            if (!empty($filteredGenap)):
                                                                                ?>
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-sm table-borderless mb-0">
                                                                                        <tbody>
                                                                                            <?php foreach ($filteredGenap as $nilai): ?>
                                                                                                <tr>
                                                                                                    <td class="py-1" style="width: 65%;">
                                                                                                        <small class="text-dark font-weight-medium"><?= $nilai['nama_mapel'] ?></small>
                                                                                                    </td>
                                                                                                    <td class="py-1 text-right">
                                                                                                        <span class="badge rounded-pill px-2 <?= $nilai['nilai'] >= 75 ? 'bg-success' : ($nilai['nilai'] >= 60 ? 'bg-warning' : 'bg-danger') ?>">
                                                                                            <?= number_format($nilai['nilai'], 1) ?>
                                                                                        </span>
                                                                            </td>
                                                                            <td class="py-1 text-right">
                                                                                <?php
                                                                                $grade = '';
                                                                                if ($nilai['nilai'] >= 90)
                                                                                    $grade = 'A';
                                                                                elseif ($nilai['nilai'] >= 80)
                                                                                    $grade = 'B';
                                                                                elseif ($nilai['nilai'] >= 70)
                                                                                    $grade = 'C';
                                                                                elseif ($nilai['nilai'] >= 60)
                                                                                    $grade = 'D';
                                                                                else
                                                                                    $grade = 'E';
                                                                                ?>
                                                                                <span class="badge rounded-pill <?= $grade == 'A' ? 'bg-success' : ($grade == 'B' ? 'bg-info' : ($grade == 'C' ? 'bg-warning' : 'bg-danger')) ?>">
                                                                                    <?= $grade; ?>
                                                                                </span>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            <?php endforeach; ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            <?php else: ?>
                                                                                <div class="text-center py-3">
                                                                                    <small class="text-muted">Belum ada nilai</small>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle-fill me-2"></i>
                                            Belum ada data nilai untuk siswa ini.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="<?= base_url('nilai'); ?>" class="btn btn-primary">
                                    <i class="bi bi-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?= $this->include('templates/footer_public') ?>