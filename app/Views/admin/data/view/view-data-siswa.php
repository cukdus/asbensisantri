<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-info">
                  <h4 class="card-title"><b>Lihat Data Siswa</b></h4>
                  <p class="card-category">Detail informasi siswa</p>
               </div>
               <div class="card-body mx-5 my-3">

                  <!-- Business Card Style Photo Section -->
                  <div class="row mb-4">
                     <div class="col-md-4">
                        <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                           <div class="card-body p-3 text-center" style="background: <?= $data['jenis_kelamin'] == 'P' ? 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)' : 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)' ?>;">
                              <div class="photo-container mb-3" style="position: relative; display: inline-block;">
                                 <?php if (!empty($data['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $data['foto'])): ?>
                                    <img src="<?= base_url('uploads/siswa/' . $data['foto']); ?>" 
                                         alt="Foto <?= $data['nama_siswa']; ?>" 
                                         class="rounded-circle border border-white" 
                                         style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;">
                                 <?php else: ?>
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" 
                                         style="width: 120px; height: 120px; border-width: 4px !important;">
                                       <i class="material-icons text-muted" style="font-size: 60px;">school</i>
                                    </div>
                                 <?php endif; ?>
                              </div>
                              <h6 class="text-white mb-1 font-weight-bold"><?= $data['nama_siswa'] ?: 'Nama Siswa' ?></h6>
                              <p class="text-white-50 mb-0 small">NIS: <?= $data['nis'] ?: '-' ?></p>
                              <p class="text-white-50 mb-0 small"><?= $data['kelas'] ?: 'Kelas' ?></p>
                              <?php if ($data['is_graduated'] == 1): ?>
                                 <span class="badge badge-warning mt-2">Alumni</span>
                              <?php else: ?>
                                 <span class="badge badge-success mt-2">Siswa Aktif</span>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-8">
                        <div class="card h-100 shadow-sm" style="border-radius: 15px;">
                           <div class="card-body">
                              <h6 class="card-title text-info mb-3">
                                 <i class="material-icons mr-2">info</i>Informasi Siswa
                              </h6>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <p class="mb-2"><strong>NIS:</strong><br><span class="text-muted"><?= $data['nis'] ?: '-' ?></span></p>
                                    <?php if (!empty($data['alamat'])): ?>
                                    <p class="mb-0"><strong>Alamat:</strong><br><span class="text-muted"><?= $data['alamat'] ?></span></p>
                                    <?php endif; ?>
                                 </div>
                                 <div class="col-sm-6">
                                    <p class="mb-2"><strong>No HP:</strong><br><span class="text-muted"><?= $data['no_hp'] ?: '-' ?></span></p>
                                    <p class="mb-2"><strong>Nama Orang Tua:</strong><br><span class="text-muted"><?= $data['nama_orang_tua'] ?: '-' ?></span></p>
                                    <p class="mb-2"><strong>Tahun Masuk:</strong><br><span class="text-muted"><?= $data['tahun_masuk'] ?: '-' ?></span></p>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Student Grades Section -->
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card shadow-sm" style="border-radius: 15px;">
                           <div class="card-body">
                              <h6 class="card-title text-info mb-3">
                                 <i class="material-icons mr-2">assessment</i>Nilai Siswa
                              </h6>
                              
                              <?php if (!empty($nilaiByYear)): ?>
                                 <?php foreach ($nilaiByYear as $tahunAjaran => $kelasList): ?>
                                    <div class="mb-4">
                                       <h6 class="text-primary mb-3">
                                          <i class="material-icons mr-1" style="font-size: 18px;">date_range</i>
                                          Tahun Ajaran <?= $tahunAjaran ?>
                                       </h6>
                                       
                                       <?php foreach ($kelasList as $kelas => $semesters): ?>
                                          <div class="card border-left-info shadow-sm mb-3">
                                             <div class="card-body p-3">
                                                <h6 class="text-info mb-3">
                                                   <i class="material-icons mr-1" style="font-size: 16px;">class</i>
                                                   Kelas <?= $kelas ?>
                                                </h6>
                                                
                                                <div class="row">
                                                   <?php foreach ($semesters as $semester => $nilaiList): ?>
                                                      <div class="col-md-6 mb-3">
                                                         <div class="border-left-primary pl-3">
                                                            <h6 class="text-secondary mb-2" style="font-size: 14px;">
                                                               <i class="material-icons mr-1" style="font-size: 14px;">book</i>
                                                               Semester <?= $semester == 'Ganjil' ? '1 (Ganjil)' : '2 (Genap)' ?>
                                                            </h6>
                                                            
                                                            <div class="table-responsive">
                                                               <table class="table table-sm table-borderless mb-0">
                                                                  <tbody>
                                                                     <?php
                $totalNilai = 0;
                $jumlahMapel = count($nilaiList);
                foreach ($nilaiList as $nilai):
                    $totalNilai += $nilai['nilai'];
                    ?>
                                                                        <tr>
                                                                           <td class="py-1" style="width: 60%;">
                                                                              <small class="text-muted"><?= $nilai['nama_mapel'] ?></small>
                                                                           </td>
                                                                           <td class="py-1 text-right">
                                                                              <span class="badge badge-<?= $nilai['nilai'] >= 75 ? 'success' : ($nilai['nilai'] >= 60 ? 'warning' : 'danger') ?> badge-pill">
                                                                                 <?= number_format($nilai['nilai'], 1) ?>
                                                                              </span>
                                                                           </td>
                                                                        </tr>
                                                                     <?php endforeach; ?>
                                                                     
                                                                     <?php if ($jumlahMapel > 0): ?>
                                                                        <tr class="border-top">
                                                                           <td class="py-2"><strong>Rata-rata:</strong></td>
                                                                           <td class="py-2 text-right">
                                                                              <?php $rataRata = $totalNilai / $jumlahMapel; ?>
                                                                              <span class="badge badge-<?= $rataRata >= 75 ? 'success' : ($rataRata >= 60 ? 'warning' : 'danger') ?> badge-pill">
                                                                                 <strong><?= number_format($rataRata, 1) ?></strong>
                                                                              </span>
                                                                           </td>
                                                                        </tr>
                                                                     <?php endif; ?>
                                                                  </tbody>
                                                               </table>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   <?php endforeach; ?>
                                                </div>
                                             </div>
                                          </div>
                                       <?php endforeach; ?>
                                       </div>
                                    </div>
                                    
                                    <?php if ($tahunAjaran !== array_key_last($nilaiByYear)): ?>
                                       <hr class="my-4">
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                              <?php else: ?>
                                 <div class="text-center py-4">
                                    <i class="material-icons text-muted" style="font-size: 48px;">assignment</i>
                                    <p class="text-muted mt-2">Belum ada data nilai untuk siswa ini</p>
                                 </div>
                              <?php endif; ?>
                           </div>
                        </div>
                     </div>
                  </div>

                  <!-- Action Buttons -->
                  <div class="text-center mt-4">
                     <a href="<?= base_url('admin/alumni'); ?>" class="btn btn-outline-secondary btn-lg px-5" style="border-radius: 25px;">
                        <i class="material-icons mr-2">arrow_back</i>Kembali ke Data Alumni
                     </a>
                     <?php if ($data['is_graduated'] == 1): ?>
                        <a href="<?= base_url('admin/siswa/edit/' . $data['id_siswa']); ?>" class="btn btn-primary btn-lg px-5 ml-3" style="border-radius: 25px;">
                           <i class="material-icons mr-2">edit</i>Edit Data
                        </a>
                     <?php endif; ?>
                     <a href="<?= base_url('admin/qr/siswa/' . $data['id_siswa'] . '/download'); ?>" class="btn btn-success btn-lg px-5 ml-3" style="border-radius: 25px;">
                        <i class="material-icons mr-2">qr_code</i>Download QR Code
                     </a>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
.photo-container:hover .photo-overlay {
   opacity: 1;
}

.card {
   transition: transform 0.2s;
}

.card:hover {
   transform: translateY(-2px);
}
</style>

<?= $this->endSection() ?>