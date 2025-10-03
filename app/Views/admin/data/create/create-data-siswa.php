<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title"><b>Form Tambah Siswa</b></h4>

               </div>
               <div class="card-body mx-5 my-3">

                  <form action="<?= base_url('admin/siswa/create'); ?>" method="post" enctype="multipart/form-data">
                     <?= csrf_field() ?>
                     <?php $validation = \Config\Services::validation(); ?>

                     <?php if (session()->getFlashdata('msg')): ?>
                        <div class="pb-2">
                           <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?> ">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <i class="material-icons">close</i>
                              </button>
                              <?= session()->getFlashdata('msg') ?>
                           </div>
                        </div>
                     <?php endif; ?>

                     <!-- Business Card Style Photo Section -->
                     <div class="row mb-5">
                        <div class="col-md-4">
                           <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                              <div class="card-body p-3 text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                 <div class="photo-container mb-3" style="position: relative; display: inline-block;">
                                    <div id="photo-preview" class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" 
                                         style="width: 120px; height: 120px; border-width: 4px !important;">
                                       <i class="material-icons text-muted" style="font-size: 60px;">school</i>
                                    </div>
                                    <div class="photo-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); border-radius: 50%; opacity: 0; transition: opacity 0.3s; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                       <i class="material-icons text-white" style="font-size: 30px;">camera_alt</i>
                                    </div>
                                 </div>
                                 <h6 class="text-white mb-1 font-weight-bold">Siswa Baru</h6>
                                 <p class="text-white-50 mb-0 small">Tambah Data Siswa</p>
                                 <p class="text-white-50 mb-0 small">Upload foto untuk melengkapi data</p>
                              </div>
                           </div>
                           <div class="mt-3">
                              <label for="foto" class="btn btn-outline-primary btn-sm btn-block">
                                 <i class="material-icons mr-1" style="font-size: 18px;">cloud_upload</i>
                                 Pilih Foto
                              </label>
                              <input type="file" id="foto" name="foto" class="d-none <?= $validation->getError('foto') ? 'is-invalid' : ''; ?>" accept="image/*" onchange="previewPhoto(this)">
                              <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF (Max: 2MB)</small>
                              <?php if ($validation->getError('foto')): ?>
                                 <div class="text-danger small mt-1"><?= $validation->getError('foto'); ?></div>
                              <?php endif; ?>
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="card h-100 shadow-sm" style="border-radius: 15px;">
                              <div class="card-body">
                                 <h6 class="card-title text-primary mb-3">
                                    <i class="material-icons mr-2">person_add</i>Form Data Siswa Baru
                                 </h6>
                                 <p class="text-muted mb-3">Lengkapi form di bawah ini untuk menambahkan data siswa baru. Pastikan semua informasi yang dimasukkan sudah benar.</p>
                                 <div class="alert alert-info">
                                    <i class="material-icons mr-2">info</i>
                                    <strong>Tips:</strong> Upload foto siswa untuk mempermudah identifikasi dan membuat kartu siswa lebih personal.
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Form Input Section -->
                     <div class="alert alert-success mt-4">
                        <i class="material-icons mr-2">auto_awesome</i>
                        <strong>NIS Otomatis:</strong> NIS akan dibuat secara otomatis dengan format PSMA[tahun][jenis kelamin][nomor urut] ketika data disimpan.
                     </div>

                     <div class="form-group mt-4">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" class="form-control <?= $validation->getError('nama') ? 'is-invalid' : ''; ?>" name="nama" placeholder="Your Name" value="<?= old('nama') ?? $oldInput['nama'] ?? '' ?>" required>
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama'); ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select class="custom-select <?= $validation->getError('id_kelas') ? 'is-invalid' : ''; ?>" id="kelas" name="id_kelas">
                           <option value="">--Pilih kelas--</option>
                           <?php foreach ($kelas as $value): ?>
                              <option value="<?= $value['id_kelas']; ?>" <?= old('id_kelas') ?? $oldInput['id_kelas'] ?? '' == $value['id_kelas'] ? 'selected' : ''; ?>>
                                 <?= $value['kelas'] . ' ' . $value['jurusan']; ?>
                              </option>
                           <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                           <?= $validation->getError('id_kelas'); ?>
                        </div>
                     </div>

                     <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <?php
                        if (old('jk')) {
                            $l = (old('jk') ?? $oldInput['jk']) == '1' ? 'checked' : '';
                            $p = (old('jk') ?? $oldInput['jk']) == '2' ? 'checked' : '';
                        }
                        ?>
                        <div class="form-check form-control pt-0 mb-1 <?= $validation->getError('jk') ? 'is-invalid' : ''; ?>" id="jk">
                           <div class="row">
                              <div class="col-auto">
                                 <div class="row">
                                    <div class="col-auto pr-1">
                                       <input class="form-check" type="radio" name="jk" id="laki" value="1" <?= $l ?? ''; ?>>
                                    </div>
                                    <div class="col">
                                       <label class="form-check-label pl-0 pt-1" for="laki">
                                          <h6 class="text-dark">Laki-laki</h6>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="col">
                                 <div class="row">
                                    <div class="col-auto pr-1">
                                       <input class="form-check" type="radio" name="jk" id="perempuan" value="2" <?= $p ?? ''; ?>>
                                    </div>
                                    <div class="col">
                                       <label class="form-check-label pl-0 pt-1" for="perempuan">
                                          <h6 class="text-dark">Perempuan</h6>
                                       </label>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="invalid-feedback">
                           <?= $validation->getError('jk'); ?>
                        </div>
                     </div>

                     <div class="mt-4 form-group">
                        <label for="hp">No HP Wali Murid</label>
                        <input type="number" id="hp" name="no_hp" class="form-control <?= $validation->getError('no_hp') ? 'is-invalid' : ''; ?>" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? '' ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('no_hp'); ?>
                        </div>
                     </div>

                     <div class="mt-4 form-group">
                        <label for="nama_orang_tua">Nama Orang Tua Santri</label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua" class="form-control <?= $validation->getError('nama_orang_tua') ? 'is-invalid' : ''; ?>" placeholder="Nama Orang Tua" value="<?= old('nama_orang_tua') ?? $oldInput['nama_orang_tua'] ?? '' ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama_orang_tua'); ?>
                        </div>
                     </div>

                     <div class="mt-4 form-group">
                        <label for="alamat">Alamat Santri</label>
                        <textarea id="alamat" name="alamat" class="form-control <?= $validation->getError('alamat') ? 'is-invalid' : ''; ?>" rows="3" placeholder="Alamat lengkap santri"><?= old('alamat') ?? $oldInput['alamat'] ?? '' ?></textarea>
                        <div class="invalid-feedback">
                           <?= $validation->getError('alamat'); ?>
                        </div>
                     </div>

                     <div class="mt-4 form-group">
                        <label for="tahun_masuk">Tahun Masuk</label>
                        <input type="number" id="tahun_masuk" name="tahun_masuk" class="form-control <?= $validation->getError('tahun_masuk') ? 'is-invalid' : ''; ?>" placeholder="2024" min="2000" max="2099" value="<?= old('tahun_masuk') ?? $oldInput['tahun_masuk'] ?? '' ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('tahun_masuk'); ?>
                        </div>
                     </div>

                     <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius: 25px;">
                           <i class="material-icons mr-2">save</i>Simpan Data Siswa
                        </button>
                        <a href="<?= base_url('admin/siswa'); ?>" class="btn btn-outline-secondary btn-lg px-5 ml-3" style="border-radius: 25px;">
                           <i class="material-icons mr-2">cancel</i>Batal
                        </a>
                     </div>
                  </form>

                  <script>
                  // Photo preview functionality
                  function previewPhoto(input) {
                     if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                           const preview = document.getElementById('photo-preview');
                           preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="rounded-circle border border-white" style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;">`;
                        };
                        reader.readAsDataURL(input.files[0]);
                     }
                  }

                  // Photo container hover effects
                  document.addEventListener('DOMContentLoaded', function() {
                     const photoContainer = document.querySelector('.photo-container');
                     const photoOverlay = document.querySelector('.photo-overlay');
                     const fotoInput = document.getElementById('foto');
                     
                     if (photoContainer && photoOverlay) {
                        photoContainer.addEventListener('mouseenter', function() {
                           photoOverlay.style.opacity = '1';
                        });
                        
                        photoContainer.addEventListener('mouseleave', function() {
                           photoOverlay.style.opacity = '0';
                        });
                        
                        photoOverlay.addEventListener('click', function() {
                           fotoInput.click();
                        });
                     }
                  });
                  </script>

                  <hr>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>