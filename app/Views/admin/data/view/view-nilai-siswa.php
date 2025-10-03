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
                              <div class="photo-container mb-3" style="position: relative; display: inline-block;">
                                 <?php if (!empty($siswa['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $siswa['foto'])): ?>
                                    <img src="<?= base_url('uploads/siswa/' . $siswa['foto']); ?>" 
                                         alt="Foto <?= $siswa['nama_siswa']; ?>" 
                                         class="rounded-circle border border-white" 
                                         style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;">
                                 <?php else: ?>
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" 
                                         style="width: 120px; height: 120px; border-width: 4px !important;">
                                       <i class="material-icons text-muted" style="font-size: 60px;">school</i>
                                    </div>
                                 <?php endif; ?>
                              </div>
                              <h6 class="text-white mb-1 font-weight-bold"><?= $siswa['nama_siswa'] ?: 'Nama Siswa' ?></h6>
                              <p class="text-white-50 mb-0 small">NIS: <?= $siswa['nis'] ?: '-' ?></p>
                              <p class="text-white-50 mb-0 small"><?= $siswa['kelas'] ?: 'Kelas' ?> <?= $siswa['jurusan'] ?: '' ?></p>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-8">
                        <div class="card shadow-sm" style="border-radius: 15px;">
                           <div class="card-body p-4">
                              <h6 class="card-title text-primary mb-3">
                                 <i class="material-icons" style="vertical-align: middle;">info</i>
                                 Informasi Siswa
                              </h6>
                              <div class="row">
                                 <div class="col-md-6">
                                    <p class="mb-2"><strong>NIS:</strong> <?= $siswa['nis'] ?: '-' ?></p>
                                    <p class="mb-2"><strong>Kelas:</strong> <?= $siswa['kelas'] ?: '-' ?> <?= $siswa['jurusan'] ?: '' ?></p>
                                    <p class="mb-2"><strong>Alamat:</strong> <?= $siswa['alamat'] ?: '-' ?></p>
                                 </div>
                                 <div class="col-md-6">
                                    <p class="mb-2"><strong>No. HP:</strong> <?= $siswa['no_hp'] ?: '-' ?></p>
                                    <p class="mb-2"><strong>Nama Orang Tua:</strong> <?= $siswa['nama_orang_tua'] ?: '-' ?></p>
                                    <p class="mb-2"><strong>Tahun Masuk:</strong> <?= $siswa['tahun_masuk'] ?: '-' ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Grades Section -->
                  <div class="row">
                     <div class="col-12">
                        <div class="card shadow-sm" style="border-radius: 15px;">
                           <div class="card-body p-4">
                              <h6 class="card-title text-success mb-3">
                                 <i class="material-icons" style="vertical-align: middle;">assessment</i>
                                 Daftar Nilai
                              </h6>
                              
                              <?php if (!empty($nilaiList)): ?>
                                 <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                       <thead class="thead-light">
                                          <tr>
                                             <th>No</th>
                                             <th>Mata Pelajaran</th>
                                             <th>Nilai</th>
                                             <th>Semester</th>
                                             <th>Tahun Ajaran</th>
                                             <th>Keterangan</th>
                                             <th>Predikat</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php $no = 1; ?>
                                          <?php foreach ($nilaiList as $nilai): ?>
                                             <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $nilai['nama_mapel']; ?></td>
                                                <td>
                                                   <span class="badge badge-<?= $nilai['nilai'] >= 75 ? 'success' : ($nilai['nilai'] >= 60 ? 'warning' : 'danger') ?> badge-pill">
                                                      <?= $nilai['nilai']; ?>
                                                   </span>
                                                </td>
                                                <td><?= $nilai['semester']; ?></td>
                                                <td><?= $nilai['tahun_ajaran']; ?></td>
                                                <td><?= $nilai['keterangan'] ?: '-'; ?></td>
                                                <td>
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
                                 <div class="text-center py-5">
                                    <i class="material-icons text-muted" style="font-size: 64px;">assignment</i>
                                    <h5 class="text-muted mt-3">Belum Ada Nilai</h5>
                                    <p class="text-muted">Siswa ini belum memiliki nilai yang tercatat.</p>
                                 </div>
                              <?php endif; ?>
                           </div>
                        </div>
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