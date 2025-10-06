<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>

<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title"><b>Form Tambah User</b></h4>
               </div>
               <div class="card-body mx-5 my-3">

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
                  
                  <form action="<?= base_url('admin/user/register') ?>" method="post" enctype="multipart/form-data">
                     <?= csrf_field() ?>
                     <?php
$validation = \Config\Services::validation();
$validationErrors = session()->getFlashdata('validation_errors') ?? [];
$oldInput = session()->getFlashdata('oldInput') ?? [];

// Helper function to get validation error
function getValidationError($field, $validation, $validationErrors)
{
    return $validationErrors[$field] ?? $validation->getError($field);
}

// Helper function to check if field has error
function hasValidationError($field, $validation, $validationErrors)
{
    return isset($validationErrors[$field]) || $validation->hasError($field);
}
?>
                           
                     <!-- Photo Upload Section -->
                     <div class="form-group text-center mb-4">
                        <label class="form-label">Foto Profil</label>
                        <div class="d-flex justify-content-center mb-3">
                           <div class="photo-container position-relative" style="cursor: pointer;">
                              <div id="photo-preview">
                                 <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 120px; height: 120px; border-width: 4px !important;">
                                    <i class="material-icons text-muted" style="font-size: 60px;">person</i>
                                 </div>
                              </div>
                              <div class="photo-overlay position-absolute w-100 h-100 rounded-circle d-flex align-items-center justify-content-center" 
                                   style="top: 0; left: 0; background: rgba(0,0,0,0.5); opacity: 0; transition: opacity 0.3s;">
                                 <i class="material-icons text-white" style="font-size: 30px;">camera_alt</i>
                              </div>
                           </div>
                        </div>
                        <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewPhoto(this)">
                        <div class="d-flex justify-content-center gap-2">
                           <button type="button" class="btn btn-sm btn-outline-primary" onclick="document.getElementById('foto').click()">
                              <i class="material-icons mr-1" style="font-size: 16px;">upload</i>Upload Foto
                           </button>
                           <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePhoto()">
                              <i class="material-icons mr-1" style="font-size: 16px;">delete</i>Hapus
                           </button>
                        </div>
                        <small class="text-muted d-block mt-2">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                        <hr style="border-top: 2px solid #e9ecef; margin: 0;">
                     </div>
                     
                     <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" class="form-control <?= getValidationError('nama_lengkap', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" name="nama_lengkap" placeholder="Masukkan nama lengkap" value="<?= old('nama_lengkap') ?? $oldInput['nama_lengkap'] ?? '' ?>">
                        <div class="invalid-feedback">
                           <?= getValidationError('nama_lengkap', $validation, $validationErrors); ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <label for="role">Role</label>
                           <select class="custom-select <?= getValidationError('role', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" id="role" name="role" onchange="toggleNuptkField()">
                           <option value="">Pilih Role</option>
                           <option value="superadmin" <?= (old('role') ?? $oldInput['role'] ?? '') == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                           <option value="guru" <?= (old('role') ?? $oldInput['role'] ?? '') == 'guru' ? 'selected' : '' ?>>Guru</option>
                           </select>
                           <div class="invalid-feedback">
                              <?= getValidationError('role', $validation, $validationErrors); ?>
                           </div>
                        </div>
                        
                        <div class="col-md-6" id="nuptk-field">
                           <label for="nuptk">NUPTK</label>
                           <input type="text" id="nuptk" name="nuptk" class="form-control" placeholder="Masukkan NUPTK (khusus guru)" value="<?= old('nuptk') ?? $oldInput['nuptk'] ?? '' ?>">
                           <small class="form-text text-muted">Kosongkan jika bukan guru</small>
                        </div>
                     </div>

                     <div class="row mt-4">
                        <div class="col-md-6">
                           <label for="alamat">Alamat</label>
                           <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"><?= old('alamat') ?? $oldInput['alamat'] ?? '' ?></textarea>
                        </div>
                        
                        <div class="col-md-6">
                           <label for="no_hp">No HP</label>
                           <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="Masukkan nomor HP" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? '' ?>">
                           
                           <div class="form-group mt-3">
                              <label>Jenis Kelamin</label>
                              <?php
$jenisKelamin = old('jenis_kelamin') ?? $oldInput['jenis_kelamin'] ?? '';
$l = $jenisKelamin == 'L' ? 'checked' : '';
$p = $jenisKelamin == 'P' ? 'checked' : '';
?>
                              <div class="form-control <?= getValidationError('jenis_kelamin', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" style="height: auto; padding: 10px;">
                                 <div class="row">
                                    <div class="col">
                                       <div class="row">
                                          <div class="col-auto pr-1">
                                             <input class="form-check" type="radio" name="jenis_kelamin" id="laki-laki" value="L" <?= $l; ?>>
                                          </div>
                                          <div class="col">
                                             <label class="form-check-label pl-0 pt-1" for="laki-laki">
                                                <h6 class="text-dark">Laki-laki</h6>
                                             </label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col">
                                       <div class="row">
                                          <div class="col-auto pr-1">
                                             <input class="form-check" type="radio" name="jenis_kelamin" id="perempuan" value="P" <?= $p; ?>>
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
                                 <?= getValidationError('jenis_kelamin', $validation, $validationErrors); ?>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row mt-4">
                        <div class="col-md-6">
                           <label for="email">Email</label>
                           <input type="email" id="email" class="form-control <?= getValidationError('email', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" name="email" placeholder="Masukkan email" value="<?= old('email') ?? $oldInput['email'] ?? '' ?>">
                           <div class="invalid-feedback">
                              <?= getValidationError('email', $validation, $validationErrors); ?>
                           </div>
                        </div>
                        
                        <div class="col-md-6">
                           <label for="username">Username</label>
                           <input type="text" id="username" class="form-control <?= getValidationError('username', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" name="username" placeholder="Masukkan username" value="<?= old('username') ?? $oldInput['username'] ?? '' ?>">
                           <div class="invalid-feedback">
                              <?= getValidationError('username', $validation, $validationErrors); ?>
                           </div>
                        </div>
                     </div>

                     <div class="row mt-4">
                        <div class="col-md-6">
                           <label for="password">Password</label>
                           <input type="password" id="password" class="form-control <?= getValidationError('password', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" name="password" placeholder="Masukkan password">
                           <div class="invalid-feedback">
                              <?= getValidationError('password', $validation, $validationErrors); ?>
                           </div>
                        </div>
                     </div>

                     <div class="form-group text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                           <i class="material-icons mr-2">save</i>Simpan
                        </button>
                        <a href="<?= base_url('admin/user') ?>" class="btn btn-warning btn-lg px-5 ml-3">
                           <i class="material-icons mr-2">cancel</i>Batal
                        </a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function toggleNuptkField() {
      const role = document.getElementById('role').value;
      const nuptkField = document.getElementById('nuptk-field');
      
      if (role === 'guru') {
         nuptkField.style.display = 'block';
      } else {
         nuptkField.style.display = 'none';
         document.getElementById('nuptk').value = '';
      }
   }
   
   // Photo upload functionality
   function previewPhoto(input) {
      if (input.files && input.files[0]) {
         const reader = new FileReader();
         reader.onload = function(e) {
            const preview = document.getElementById('photo-preview');
            preview.innerHTML = `<img src="${e.target.result}" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid white;">`;
         };
         reader.readAsDataURL(input.files[0]);
      }
   }
   
   function removePhoto() {
      const preview = document.getElementById('photo-preview');
      const fileInput = document.getElementById('foto');
      
      preview.innerHTML = `
         <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 120px; height: 120px; border-width: 4px !important;">
            <i class="material-icons text-muted" style="font-size: 60px;">person</i>
         </div>
      `;
      fileInput.value = '';
   }
   
   // Photo hover effect
   document.addEventListener('DOMContentLoaded', function() {
      toggleNuptkField();
      
      const photoContainer = document.querySelector('.photo-container');
      const photoOverlay = document.querySelector('.photo-overlay');
      
      photoContainer.addEventListener('mouseenter', function() {
         photoOverlay.style.opacity = '1';
      });
      
      photoContainer.addEventListener('mouseleave', function() {
         photoOverlay.style.opacity = '0';
      });
      
      photoContainer.addEventListener('click', function() {
         document.getElementById('foto').click();
      });
   });
</script>

<?= $this->endSection() ?>