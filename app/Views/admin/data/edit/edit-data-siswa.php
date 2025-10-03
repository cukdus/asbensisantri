<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title"><b>Form Edit Siswa</b></h4>

               </div>
               <div class="card-body mx-5 my-3">

                  <form action="<?= base_url('admin/siswa/edit'); ?>" method="post" enctype="multipart/form-data">
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

                     <input type="hidden" name="id" value="<?= $data['id_siswa']; ?>">

                     <!-- Business Card Style Photo Section -->
                     <div class="row mb-4">
                        <div class="col-md-4">
                           <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                              <div class="card-body p-3 text-center" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                 <div class="photo-container mb-3" style="position: relative; display: inline-block;">
                                    <?php if (!empty($data['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $data['foto'])): ?>
                                       <img id="photo-preview" src="<?= base_url('uploads/siswa/' . $data['foto']); ?>" 
                                            alt="Foto <?= $data['nama_siswa']; ?>" 
                                            class="rounded-circle border border-white" 
                                            style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;">
                                    <?php else: ?>
                                       <div id="photo-preview" class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" 
                                            style="width: 120px; height: 120px; border-width: 4px !important;">
                                          <i class="material-icons text-muted" style="font-size: 60px;">school</i>
                                       </div>
                                    <?php endif; ?>
                                    <div class="photo-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); border-radius: 50%; opacity: 0; transition: opacity 0.3s; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                       <i class="material-icons text-white" style="font-size: 30px;">camera_alt</i>
                                    </div>
                                 </div>
                                 <h6 class="text-white mb-1 font-weight-bold"><?= $data['nama_siswa'] ?: 'Nama Siswa' ?></h6>
                                 <p class="text-white-50 mb-0 small">NIS: <?= $data['nis'] ?: '-' ?></p>
                                 <p class="text-white-50 mb-0 small"><?= $data['kelas'] ?: 'Kelas' ?></p>
                              </div>
                           </div>
                           <div class="mt-3">
                              <label for="foto" class="btn btn-outline-primary btn-sm btn-block">
                                 <i class="material-icons mr-1" style="font-size: 18px;">cloud_upload</i>
                                 Pilih Foto
                              </label>
                              <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                              <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF (Max: 2MB)</small>
                              <?php if (!empty($data['foto'])): ?>
                                 <button type="button" class="btn btn-outline-danger btn-sm btn-block mt-2" onclick="removePhoto()">
                                    <i class="material-icons mr-1" style="font-size: 18px;">delete</i>
                                    Hapus Foto
                                 </button>
                                 <input type="hidden" id="remove_foto" name="remove_foto" value="0">
                              <?php endif; ?>
                           </div>
                        </div>
                        <div class="col-md-8">
                           <div class="card h-100 shadow-sm" style="border-radius: 15px;">
                              <div class="card-body">
                                 <h6 class="card-title text-primary mb-3">
                                    <i class="material-icons mr-2">info</i>Informasi Siswa
                                 </h6>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <p class="mb-2"><strong>NIS:</strong><br><span class="text-muted"><?= $data['nis'] ?: '-' ?></span></p>
                                       <p class="mb-2"><strong>Kelas:</strong><br><span class="text-muted"><?= $data['kelas'] ?: '-' ?></span></p>
                                       <p class="mb-2"><strong>Jenis Kelamin:</strong><br><span class="text-muted"><?= $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : ($data['jenis_kelamin'] == 'P' ? 'Perempuan' : '-') ?></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                       <p class="mb-2"><strong>No HP:</strong><br><span class="text-muted"><?= $data['no_hp'] ?: '-' ?></span></p>
                                       <p class="mb-2"><strong>Nama Orang Tua:</strong><br><span class="text-muted"><?= $data['nama_orang_tua'] ?: '-' ?></span></p>
                                       <p class="mb-2"><strong>Tahun Masuk:</strong><br><span class="text-muted"><?= $data['tahun_masuk'] ?: '-' ?></span></p>
                                    </div>
                                 </div>
                                 <?php if (!empty($data['alamat'])): ?>
                                    <p class="mb-0"><strong>Alamat:</strong><br><span class="text-muted"><?= $data['alamat'] ?></span></p>
                                 <?php endif; ?>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="form-group mt-4">
                        <label for="nis">NIS</label>
                        <input type="text" id="nis" class="form-control" name="nis" value="<?= $data['nis'] ?>" readonly>
                        <small class="text-muted">NIS tidak dapat diubah karena dibuat secara otomatis oleh sistem.</small>
                     </div>

                     <div class="form-group mt-4">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" class="form-control <?= $validation->getError('nama') ? 'is-invalid' : ''; ?>" name="nama" placeholder="Your Name" value="<?= old('nama') ?? $oldInput['nama'] ?? $data['nama_siswa'] ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama'); ?>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">
                           <label for="kelas">Kelas</label>
                           <select class="custom-select <?= $validation->getError('id_kelas') ? 'is-invalid' : ''; ?>" id="kelas" name="id_kelas">
                              <option value="">--Pilih kelas--</option>
                              <?php foreach ($kelas as $value): ?>
                                 <option value="<?= $value['id_kelas']; ?>" <?= old('id_kelas') ?? $oldInput['id_kelas'] ?? $value['id_kelas'] == $data['id_kelas'] ? 'selected' : ''; ?>>
                                    <?= $value['kelas'] . ' ' . $value['jurusan']; ?>
                                 </option>
                              <?php endforeach; ?>
                           </select>
                           <div class="invalid-feedback">
                              <?= $validation->getError('id_kelas'); ?>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <label for="jk">Jenis Kelamin</label>
                           <?php
$jenisKelamin = (old('jk') ?? $oldInput['jk'] ?? $data['jenis_kelamin']);
$l = $jenisKelamin == 'Laki-laki' || $jenisKelamin == '1' ? 'checked' : '';
$p = $jenisKelamin == 'Perempuan' || $jenisKelamin == '2' ? 'checked' : '';
?>
                           <div class="form-check form-control pt-0 mb-1 <?= $validation->getError('jk') ? 'is-invalid' : ''; ?>" id="jk">
                              <div class="row">
                                 <div class="col-auto">
                                    <div class="row">
                                       <div class="col-auto pr-1">
                                          <input class="form-check" type="radio" name="jk" id="laki" value="1" <?= $l; ?>>
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
                                          <input class="form-check" type="radio" name="jk" id="perempuan" value="2" <?= $p; ?>>
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
                     </div>

                     <div class="form-group mt-5">
                        <label for="hp">No HP</label>
                        <input type="number" id="hp" name="no_hp" class="form-control <?= $validation->getError('no_hp') ? 'is-invalid' : ''; ?>" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? $data['no_hp'] ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('no_hp'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-5">
                        <label for="nama_orang_tua">Nama Orang Tua Santri</label>
                        <input type="text" id="nama_orang_tua" name="nama_orang_tua" class="form-control <?= $validation->getError('nama_orang_tua') ? 'is-invalid' : ''; ?>" placeholder="Nama Orang Tua" value="<?= old('nama_orang_tua') ?? $oldInput['nama_orang_tua'] ?? $data['nama_orang_tua'] ?? '' ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama_orang_tua'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-5">
                        <label for="alamat">Alamat Santri</label>
                        <textarea id="alamat" name="alamat" class="form-control <?= $validation->getError('alamat') ? 'is-invalid' : ''; ?>" rows="3" placeholder="Alamat lengkap santri"><?= old('alamat') ?? $oldInput['alamat'] ?? $data['alamat'] ?? '' ?></textarea>
                        <div class="invalid-feedback">
                           <?= $validation->getError('alamat'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-5">
                        <label for="tahun_masuk">Tahun Masuk</label>
                        <input type="number" id="tahun_masuk" name="tahun_masuk" class="form-control <?= $validation->getError('tahun_masuk') ? 'is-invalid' : ''; ?>" placeholder="2024" min="2000" max="2099" value="<?= old('tahun_masuk') ?? $oldInput['tahun_masuk'] ?? $data['tahun_masuk'] ?? '' ?>">
                        <div class="invalid-feedback">
                           <?= $validation->getError('tahun_masuk'); ?>
                        </div>
                     </div>

                     <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                  </form>

                  <script>
                  function previewPhoto(input) {
                     if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                           const preview = document.getElementById('photo-preview');
                           if (preview.tagName === 'IMG') {
                              preview.src = e.target.result;
                           } else {
                              preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="rounded-circle border border-white" style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;">`;
                           }
                        }
                        reader.readAsDataURL(input.files[0]);
                     }
                  }

                  function removePhoto() {
                     if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                        document.getElementById('remove_foto').value = '1';
                        const preview = document.getElementById('photo-preview');
                        preview.innerHTML = '<i class="material-icons text-muted" style="font-size: 60px;">school</i>';
                        preview.className = 'bg-light rounded-circle d-flex align-items-center justify-content-center border border-white';
                        preview.style.cssText = 'width: 120px; height: 120px; border-width: 4px !important;';
                        document.getElementById('foto').value = '';
                     }
                  }

                  // Add hover effect for photo overlay
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