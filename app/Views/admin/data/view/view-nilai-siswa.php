<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-info">
                  <h4 class="card-title"><b>Lihat Nilai Siswa</b></h4>
                  <p class="card-category">
                     Siswa: <?= $siswa['nama_siswa']; ?> (<?= $siswa['nis']; ?>) - <?= $siswa['kelas']; ?> <?= $siswa['jurusan']; ?>
                  </p>
               </div>
               <div class="card-body mx-5 my-3">

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
                                    <p class="mb-2"><strong>Kelas:</strong><br><span class="text-muted"><?= $siswa['kelas'] ?: '-' ?> <?= $siswa['jurusan'] ?: '' ?></span></p>
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

                  <!-- Grades Section -->
                  <div class="row">
                     <div class="col-12">
                        <h6 class="card-title text-success mb-3">
                           <i class="material-icons" style="vertical-align: middle;">assessment</i>
                           Daftar Nilai
                        </h6>
                        
                        <?php if (!empty($nilaiList)): ?>
                           <?php
    // Kelompokkan nilai berdasarkan tahun ajaran, kelas, dan semester
    $nilaiByYear = [];
    foreach ($nilaiList as $nilai) {
        $tahunAjaran = $nilai['tahun_ajaran'];
        $semester = $nilai['semester'];
        $kelas = $nilai['kelas'] ?: 'Tidak Diketahui';

        if (!isset($nilaiByYear[$tahunAjaran])) {
            $nilaiByYear[$tahunAjaran] = [];
        }

        if (!isset($nilaiByYear[$tahunAjaran][$kelas])) {
            $nilaiByYear[$tahunAjaran][$kelas] = [];
        }

        if (!isset($nilaiByYear[$tahunAjaran][$kelas][$semester])) {
            $nilaiByYear[$tahunAjaran][$kelas][$semester] = [];
        }

        $nilaiByYear[$tahunAjaran][$kelas][$semester][] = $nilai;
    }
?>
                           
                           <?php
    // Mengurutkan tahun ajaran dari terbaru ke terlama
    krsort($nilaiByYear);

    foreach ($nilaiByYear as $tahunAjaran => $kelasList):
        ?>
                              <div class="mb-4">
                                 <h6 class="text-primary mb-3">
                                    <i class="material-icons mr-1" style="font-size: 18px;">date_range</i>
                                    Tahun Ajaran <?= $tahunAjaran ?>
                                 </h6>
                                 
                                 <?php foreach ($kelasList as $kelas => $semesters): ?>
                                    <div class="card border-left-info shadow-sm mb-4" style="border-radius: 12px;">
                                       <div class="card-header bg-light py-2 px-3" style="border-radius: 12px 12px 0 0;">
                                          <h6 class="text-info mb-0 font-weight-bold">
                                             <i class="material-icons mr-2" style="font-size: 18px; vertical-align: middle;">class</i>
                                             Kelas <?= $kelas ?>
                                             <small class="text-muted ml-2">(<?= count($semesters) ?> Semester)</small>
                                          </h6>
                                       </div>
                                       <div class="card-body p-4">
                                          <div class="row">
                                             <?php
            // Organize semesters to ensure Ganjil and Genap are displayed side by side
            $semesterGanjil = isset($semesters['Ganjil']) ? $semesters['Ganjil'] : [];
            $semesterGenap = isset($semesters['Genap']) ? $semesters['Genap'] : [];
            ?>
                                             
                                             <!-- Semester Ganjil -->
                                             <div class="col-md-6 mb-3">
                                                <div class="card border-0 bg-light h-100" style="border-radius: 8px;">
                                                   <div class="card-body p-3">
                                                      <div class="d-flex align-items-center mb-3">
                                                         <div class="bg-primary rounded-circle p-2 mr-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="material-icons text-white" style="font-size: 18px;">book</i>
                                                         </div>
                                                         <div>
                                                            <h6 class="mb-0 font-weight-bold text-primary">
                                                               Semester 1
                                                            </h6>
                                                            <small class="text-muted">Ganjil</small>
                                                         </div>
                                                      </div>
                                                      
                                                      <?php if (!empty($semesterGanjil)): ?>
                                                         <div class="table-responsive">
                                                            <table class="table table-sm table-borderless mb-0">
                                                               <tbody>
                                                                  <?php foreach ($semesterGanjil as $nilai): ?>
                                                                     <tr>
                                                                        <td class="py-1" style="width: 65%;">
                                                                           <small class="text-dark font-weight-medium"><?= $nilai['nama_mapel'] ?></small>
                                                                        </td>
                                                                        <td class="py-1 text-right">
                                                                           <span class="badge badge-<?= $nilai['nilai'] >= 75 ? 'success' : ($nilai['nilai'] >= 60 ? 'warning' : 'danger') ?> badge-pill px-2">
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
                                                                           <span class="badge badge-<?= $grade == 'A' ? 'success' : ($grade == 'B' ? 'info' : ($grade == 'C' ? 'warning' : 'danger')) ?> badge-pill">
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
                                                         <div class="bg-success rounded-circle p-2 mr-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                            <i class="material-icons text-white" style="font-size: 18px;">book</i>
                                                         </div>
                                                         <div>
                                                            <h6 class="mb-0 font-weight-bold text-success">
                                                               Semester 2
                                                            </h6>
                                                            <small class="text-muted">Genap</small>
                                                         </div>
                                                      </div>
                                                      
                                                      <?php if (!empty($semesterGenap)): ?>
                                                         <div class="table-responsive">
                                                            <table class="table table-sm table-borderless mb-0">
                                                               <tbody>
                                                                  <?php foreach ($semesterGenap as $nilai): ?>
                                                                     <tr>
                                                                        <td class="py-1" style="width: 65%;">
                                                                           <small class="text-dark font-weight-medium"><?= $nilai['nama_mapel'] ?></small>
                                                                        </td>
                                                                        <td class="py-1 text-right">
                                                                           <span class="badge badge-<?= $nilai['nilai'] >= 75 ? 'success' : ($nilai['nilai'] >= 60 ? 'warning' : 'danger') ?> badge-pill px-2">
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
                                                                           <span class="badge badge-<?= $grade == 'A' ? 'success' : ($grade == 'B' ? 'info' : ($grade == 'C' ? 'warning' : 'danger')) ?> badge-pill">
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
                           <div class="card shadow-sm" style="border-radius: 15px;">
                              <div class="card-body p-4">
                                 <div class="text-center py-5">
                                    <i class="material-icons text-muted" style="font-size: 64px;">assignment</i>
                                    <h5 class="text-muted mt-3">Belum Ada Nilai</h5>
                                    <p class="text-muted">Siswa ini belum memiliki nilai yang tercatat.</p>
                                 </div>
                              </div>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="row mt-4">
                     <div class="col-12">
                        <div class="text-center">
                           <a href="<?= base_url('admin/nilai/tambah-nilai-siswa/' . $siswa['id_siswa']); ?>" class="btn btn-success btn-round">
                              <i class="material-icons">add</i>
                              Tambah Nilai
                           </a>
                           <a href="<?= base_url('admin/nilai/kelas/' . $siswa['id_kelas']); ?>" class="btn btn-info btn-round">
                              <i class="material-icons">arrow_back</i>
                              Kembali ke Daftar Siswa
                           </a>
                           <a href="<?= base_url('admin/nilai'); ?>" class="btn btn-secondary btn-round">
                              <i class="material-icons">list</i>
                              Lihat Semua Nilai
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
<?= $this->endSection() ?>