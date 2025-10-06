<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title"><b>Form Edit <?= ucfirst($data['role']) ?></b></h4>

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
                  
                  <form action="<?= base_url('admin/user/edit') ?>" method="post" enctype="multipart/form-data">
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
                     <input type="hidden" name="id" value="<?= $data['id'] ?>">

                     <!-- Business Card Style Photo Section -->
                     <div class="row mb-4">
                        <div class="col-md-4">
                           <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
                              <div class="card-body p-3 text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                 <div class="photo-container mb-1" style="position: relative; display: inline-block;">
                                    <?php if (!empty($data['foto']) && file_exists(FCPATH . 'uploads/users/' . $data['foto'])): ?>
                                       <img id="photo-preview" src="<?= base_url('uploads/users/' . $data['foto']); ?>" 
                                            alt="Foto <?= $data['nama_lengkap']; ?>" 
                                            class="rounded-circle border border-white" 
                                            style="width: 200px; height: 200px; object-fit: cover; border-width: 4px !important;">
                                    <?php else: ?>
                                       <div id="photo-preview" class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" 
                                            style="width: 200px; height: 200px; border-width: 4px !important;">
                                          <i class="material-icons text-muted" style="font-size: 60px;">person</i>
                                       </div>
                                    <?php endif; ?>
                                    <div class="photo-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); border-radius: 50%; opacity: 0; transition: opacity 0.3s; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                       <i class="material-icons text-white" style="font-size: 30px;">camera_alt</i>
                                    </div>
                                 </div>
                                 
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
                                 <h2 class="card-title text-primary mb-3">
                                    <?= $data['nama_lengkap'] ?: 'Nama User' ?>
                                 </h2>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <p class="mb-2"><strong>Email:</strong><br><span class="text-muted"><?= $data['email'] ?: '-' ?></span></p>
                                       <p class="mb-2"><strong>Username:</strong><br><span class="text-muted"><?= $data['username'] ?: '-' ?></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                       <p class="mb-2"><strong>No HP:</strong><br><span class="text-muted"><?= $data['no_hp'] ?: '-' ?></span></p>
                                    <?php if (!empty($data['alamat'])): ?>
                                       <p class="mb-0"><strong>Alamat:</strong><br><span class="text-muted"><?= $data['alamat'] ?></span></p>
                                    <?php endif; ?>
                                    </div>
                                 </div>
                                 
                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <!-- Spacing between business card and form groups -->
                     <div style="margin-top: 3rem; margin-bottom: 2rem;">
                        <hr style="border-top: 2px solid #e9ecef; margin: 0;">
                     </div>
                     
                     <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" class="form-control <?= getValidationError('nama_lengkap', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" name="nama_lengkap" placeholder="Masukkan nama lengkap" value="<?= old('nama_lengkap') ?? $oldInput['nama_lengkap'] ?? $data['nama_lengkap'] ?>">
                        <div class="invalid-feedback">
                           <?= getValidationError('nama_lengkap', $validation, $validationErrors); ?>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <label for="role">Role</label>
                           <select class="custom-select <?= getValidationError('role', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" id="role" name="role" onchange="toggleNuptkField()">
                           <option value="">Pilih Role</option>
                           <option value="superadmin" <?= (old('role') ?? $oldInput['role'] ?? $data['role']) == 'superadmin' ? 'selected' : '' ?>>Super Admin</option>
                           <option value="guru" <?= (old('role') ?? $oldInput['role'] ?? $data['role']) == 'guru' ? 'selected' : '' ?>>Guru</option>
                        </select>
                        <div class="invalid-feedback">
                           <?= getValidationError('role', $validation, $validationErrors); ?>
                        </div>
                        </div>
                        <div class="col-md-6">
                           <label for="jk">Jenis Kelamin</label>
                           <?php
$jenisKelamin = (old('jenis_kelamin') ?? $oldInput['jenis_kelamin'] ?? $data['jenis_kelamin']);
// Handle both form values (L/P) and database values (Laki-laki/Perempuan)
$l = ($jenisKelamin == 'L' || $jenisKelamin == 'Laki-laki') ? 'checked' : '';
$p = ($jenisKelamin == 'P' || $jenisKelamin == 'Perempuan') ? 'checked' : '';
?>
                           <div class="form-check form-control pt-0 mb-1 <?= getValidationError('jenis_kelamin', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" id="jk">
                              <div class="row">
                                 <div class="col-auto">
                                    <div class="row">
                                       <div class="col-auto pr-1">
                                          <input class="form-check" type="radio" name="jenis_kelamin" id="laki" value="L" <?= $l; ?>>
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

                     <div class="form-group mt-5">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control <?= getValidationError('username', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" placeholder="Masukkan username" value="<?= old('username') ?? $oldInput['username'] ?? $data['username'] ?>">
                        <div class="invalid-feedback">
                           <?= getValidationError('username', $validation, $validationErrors); ?>
                        </div>
                     </div>

                     <div class="form-group mt-5">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control <?= getValidationError('email', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" placeholder="Masukkan email" value="<?= old('email') ?? $oldInput['email'] ?? $data['email'] ?>">
                        <div class="invalid-feedback">
                           <?= getValidationError('email', $validation, $validationErrors); ?>
                        </div>
                     </div>

                     <div class="form-group mt-5">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control <?= getValidationError('password', $validation, $validationErrors) ? 'is-invalid' : ''; ?>" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                        <div class="invalid-feedback">
                           <?= getValidationError('password', $validation, $validationErrors); ?>
                        </div>
                     </div>

                     <div class="form-group mt-5" id="nuptk-field">
                        <label for="nuptk">NUPTK</label>
                        <input type="text" id="nuptk" name="nuptk" class="form-control" placeholder="Masukkan NUPTK (khusus guru)" value="<?= old('nuptk') ?? $oldInput['nuptk'] ?? $data['nuptk'] ?? '' ?>">
                        <small class="form-text text-muted">Kosongkan jika bukan guru</small>
                     </div>

                     <div class="form-group mt-5">
                        <label for="no_hp">No HP</label>
                        <input type="text" id="no_hp" name="no_hp" class="form-control" placeholder="Masukkan nomor HP" value="<?= old('no_hp') ?? $oldInput['no_hp'] ?? $data['no_hp'] ?? '' ?>">
                     </div>

                     <div class="form-group mt-5">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat"><?= old('alamat') ?? $oldInput['alamat'] ?? $data['alamat'] ?? '' ?></textarea>
                     </div>

                     <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                  </form>

                  <hr>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
// Photo handling functions
function previewPhoto(input) {
   if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
         const preview = document.getElementById('photo-preview');
         preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" class="rounded-circle border border-white" style="width: 120px; height: 120px; object-fit: cover; border-width: 4px !important;">';
         
         // Reset remove photo flag
         const removeFlag = document.getElementById('remove_foto');
         if (removeFlag) removeFlag.value = '0';
      };
      reader.readAsDataURL(input.files[0]);
   }
}

function removePhoto() {
   const preview = document.getElementById('photo-preview');
   preview.innerHTML = '<div class="bg-light rounded-circle d-flex align-items-center justify-content-center border border-white" style="width: 120px; height: 120px; border-width: 4px !important;"><i class="material-icons text-muted" style="font-size: 60px;">person</i></div>';
   
   // Clear file input
   document.getElementById('foto').value = '';
   
   // Set remove flag
   const removeFlag = document.getElementById('remove_foto');
   if (removeFlag) removeFlag.value = '1';
}

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

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
   toggleNuptkField();
   
   // Add hover effect to photo container
   const photoContainer = document.querySelector('.photo-container');
   const photoOverlay = document.querySelector('.photo-overlay');
   
   if (photoContainer && photoOverlay) {
      photoContainer.addEventListener('mouseenter', function() {
         photoOverlay.style.opacity = '1';
      });
      
      photoContainer.addEventListener('mouseleave', function() {
         photoOverlay.style.opacity = '0';
      });
      
      photoOverlay.addEventListener('click', function() {
         document.getElementById('foto').click();
      });
   }
});
</script>

<?= $this->endSection() ?>