<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-info">
                  <h4 class="card-title"><b>Lihat Data<?php if ($data['is_graduated'] == 1): ?>
                                 <span>Alumni</span>
                              <?php else: ?>
                                 <span>Siswa Aktif</span>
                              <?php endif; ?></b></h4>
                  <p class="card-category">Detail informasi siswa</p>
               </div>
               <div class="card-body mx-5 my-3">

                  <!-- Business Card Style Photo Section -->
                  <div class="row mb-4">
                     <div class="col-md-4">
                        <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                           <div class="card-body p-3 text-center" style="background: <?= $data['jenis_kelamin'] == 'P' ? 'linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%)' : 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)' ?>;">
                              <div class="photo-container mb-1" style="position: relative; display: inline-block;">
                                 <?php if (!empty($data['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $data['foto'])): ?>
                                    <img src="<?= base_url('uploads/siswa/' . $data['foto']); ?>" 
                                         alt="Foto <?= $data['nama_siswa']; ?>" 
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
                              <h2 class="card-title text-info mb-3">
                                 <?= $data['nama_siswa'] ?: 'Nama Siswa' ?> <?php if ($data['is_graduated'] == 1): ?>
                                 <span class="badge badge-warning mt-2">Lulus <?= $data['tahun_lulus'] ?: '-' ?></span>
                              <?php else: ?>
                                 <span class="badge badge-success mt-2">Siswa Aktif</span>
                              <?php endif; ?>
                              </h2>
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
                                                                        <?php
                                                                        $totalNilaiGanjil = 0;
                                                                        $jumlahMapelGanjil = count($semesterGanjil);
                                                                        foreach ($semesterGanjil as $nilai):
                                                                            $totalNilaiGanjil += $nilai['nilai'];
                                                                            ?>
                                                                           <tr>
                                                                              <td class="py-1" style="width: 65%;">
                                                                                 <small class="text-dark font-weight-medium"><?= $nilai['nama_mapel'] ?></small>
                                                                              </td>
                                                                              <td class="py-1 text-right">
                                                                                 <span class="badge badge-<?= $nilai['nilai'] >= 75 ? 'success' : ($nilai['nilai'] >= 60 ? 'warning' : 'danger') ?> badge-pill px-2">
                                                                                    <?= number_format($nilai['nilai'], 1) ?>
                                                                                 </span>
                                                                              </td>
                                                                           </tr>
                                                                        <?php endforeach; ?>
                                                                        
                                                                        <?php if ($jumlahMapelGanjil > 0): ?>
                                                                           <tr class="border-top">
                                                                              <td class="py-2"><strong class="text-primary">Rata-rata:</strong></td>
                                                                              <td class="py-2 text-right">
                                                                                 <?php $rataRataGanjil = $totalNilaiGanjil / $jumlahMapelGanjil; ?>
                                                                                 <span class="badge badge-<?= $rataRataGanjil >= 75 ? 'success' : ($rataRataGanjil >= 60 ? 'warning' : 'danger') ?> badge-pill px-2">
                                                                                    <strong><?= number_format($rataRataGanjil, 1) ?></strong>
                                                                                 </span>
                                                                              </td>
                                                                           </tr>
                                                                        <?php endif; ?>
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
                                                                        <?php
                                                                        $totalNilaiGenap = 0;
                                                                        $jumlahMapelGenap = count($semesterGenap);
                                                                        foreach ($semesterGenap as $nilai):
                                                                            $totalNilaiGenap += $nilai['nilai'];
                                                                            ?>
                                                                           <tr>
                                                                              <td class="py-1" style="width: 65%;">
                                                                                 <small class="text-dark font-weight-medium"><?= $nilai['nama_mapel'] ?></small>
                                                                              </td>
                                                                              <td class="py-1 text-right">
                                                                                 <span class="badge badge-<?= $nilai['nilai'] >= 75 ? 'success' : ($nilai['nilai'] >= 60 ? 'warning' : 'danger') ?> badge-pill px-2">
                                                                                    <?= number_format($nilai['nilai'], 1) ?>
                                                                                 </span>
                                                                              </td>
                                                                           </tr>
                                                                        <?php endforeach; ?>
                                                                        
                                                                        <?php if ($jumlahMapelGenap > 0): ?>
                                                                           <tr class="border-top">
                                                                              <td class="py-2"><strong class="text-success">Rata-rata:</strong></td>
                                                                              <td class="py-2 text-right">
                                                                                 <?php $rataRataGenap = $totalNilaiGenap / $jumlahMapelGenap; ?>
                                                                                 <span class="badge badge-<?= $rataRataGenap >= 75 ? 'success' : ($rataRataGenap >= 60 ? 'warning' : 'danger') ?> badge-pill px-2">
                                                                                    <strong><?= number_format($rataRataGenap, 1) ?></strong>
                                                                                 </span>
                                                                              </td>
                                                                           </tr>
                                                                        <?php endif; ?>
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
                        <!-- Action Buttons -->
                        <div class="text-center mt-1 mb-3">
                           <a href="<?= base_url('admin/alumni'); ?>" class="btn btn-outline-secondary btn-lg px-5" style="border-radius: 25px;">
                              <i class="material-icons mr-2">arrow_back</i>Kembali ke Data Alumni
                           </a>
                           <!-- php if ($data['is_graduated'] == 1): ?>
                              <a href="<!--?= base_url('admin/siswa/edit/' . $data['id_siswa']); ?>" class="btn btn-primary btn-lg px-5 ml-3" style="border-radius: 25px;">
                                 <i class="material-icons mr-2">edit</i>Edit Data
                              </a>
                           <!--?php endif; ?>
                           <a href="<!--?= base_url('admin/qr/siswa/' . $data['id_siswa'] . '/download'); ?>" class="btn btn-success btn-lg px-5 ml-3" style="border-radius: 25px;">
                              <i class="material-icons mr-2">qr_code</i>Download QR Code
                           </a -->
                        </div>
                     </div>
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