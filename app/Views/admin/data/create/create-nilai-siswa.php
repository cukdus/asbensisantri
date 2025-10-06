<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-success">
                  <h4 class="card-title"><b>Form Tambah Nilai Siswa</b></h4>
                  <p class="card-category">
                     Siswa: <?= $siswa['nama_siswa']; ?> (<?= $siswa['nis']; ?>) - <?= $siswa['kelas']; ?> <?= $siswa['jurusan']; ?>
                  </p>
               </div>
               <div class="card-body mx-5 my-3">

                  <?php if (session()->getFlashdata('msg')): ?>
                     <div class="pb-2">
                        <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?>">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="material-icons">close</i>
                           </button>
                           <?= session()->getFlashdata('msg') ?>
                        </div>
                     </div>
                  <?php endif; ?>

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

                  <form action="<?= base_url('admin/nilai/create'); ?>" method="post">
                     <?= csrf_field() ?>
                     <?php $validation = \Config\Services::validation(); ?>
                     <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">

                     <!-- Mata Pelajaran Table Section -->
                     <div class="row">
                        <div class="col-md-12">
                           <div class="card shadow-sm" style="border-radius: 15px;">
                              <div class="card-header card-header-info">
                                 <h6 class="card-title mb-0"><b>Input Nilai Mata Pelajaran</b></h6>
                                 <p class="card-category mb-0">Masukkan nilai untuk setiap mata pelajaran</p>
                              </div>
                              <div class="card-body">
                                 <div class="table-responsive">
                                    <table class="table table-striped">
                                       <thead class="text-info">
                                          <tr>
                                             <th width="40%"><b>Nama Mata Pelajaran</b></th>
                                             <th width="20%"><b>Input Nilai (0-100)</b></th>
                                             <th width="40%"><b>Keterangan</b></th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <?php foreach ($mapelList as $index => $m): ?>
                                             <tr>
                                                <td>
                                                   <strong><?= $m['nama_mapel']; ?></strong>
                                                   <input type="hidden" name="mapel[<?= $index ?>][id_mapel]" value="<?= $m['id_mapel']; ?>">
                                                   <input type="hidden" name="mapel[<?= $index ?>][nama_mapel]" value="<?= $m['nama_mapel']; ?>">
                                                </td>
                                                <td>
                                                   <div class="form-group mb-0">
                                                      <input type="number" 
                                                             class="form-control form-control-sm" 
                                                             name="mapel[<?= $index ?>][nilai]" 
                                                             id="nilai_<?= $m['id_mapel']; ?>"
                                                             min="0" 
                                                             max="100" 
                                                             step="0.01" 
                                                             placeholder="0-100"
                                                             value="<?= old('mapel.' . $index . '.nilai'); ?>">
                                                   </div>
                                                </td>
                                                <td>
                                                   <div class="form-group mb-0">
                                                      <input type="text" 
                                                             class="form-control form-control-sm" 
                                                             name="mapel[<?= $index ?>][keterangan]" 
                                                             id="keterangan_<?= $m['id_mapel']; ?>"
                                                             placeholder="Keterangan (opsional)"
                                                             value="<?= old('mapel.' . $index . '.keterangan'); ?>">
                                                   </div>
                                                </td>
                                             </tr>
                                          <?php endforeach; ?>
                                       </tbody>
                                    </table>
                                 </div>
                                 <div class="alert alert-info mt-3">
                                    <i class="material-icons">info</i>
                                    <strong>Petunjuk:</strong> Anda dapat mengisi nilai untuk beberapa mata pelajaran sekaligus. Kosongkan field nilai jika tidak ingin menambahkan nilai untuk mata pelajaran tersebut.
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Additional Information Section -->
                     <div class="row mt-4">
                        <div class="col-md-12">
                           <div class="card shadow-sm" style="border-radius: 15px;">
                              <div class="card-header card-header-info">
                                 <h6 class="card-title mb-0"><b>Informasi Tambahan</b></h6>
                                 <p class="card-category mb-0">Semester dan tahun ajaran</p>
                              </div>
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="bmd-label-floating">Semester</label>
                                          <select class="form-control" name="semester" required>
                                             <option value="">Pilih Semester</option>
                                             <option value="1" <?= old('semester') == '1' ? 'selected' : ''; ?>>Semester 1</option>
                                             <option value="2" <?= old('semester') == '2' ? 'selected' : ''; ?>>Semester 2</option>
                                          </select>
                                          <?php if ($validation->hasError('semester')): ?>
                                             <div class="text-danger">
                                                <small><?= $validation->getError('semester'); ?></small>
                                             </div>
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class="form-group">
                                          <label class="bmd-label-floating">Tahun Ajaran</label>
                                          <select class="form-control" name="tahun_ajaran" required>
                                             <option value="">Pilih Tahun Ajaran</option>
                                             <?php
$currentYear = date('Y');
$oldValue = old('tahun_ajaran');

// Generate tahun ajaran dari 2 tahun kebelakang sampai 2 tahun kedepan
for ($i = -2; $i <= 2; $i++) {
    $startYear = $currentYear + $i;
    $endYear = $startYear + 1;
    $tahunAjaran = $startYear . '/' . $endYear;
    $selected = '';

    // Set default ke tahun ajaran saat ini jika tidak ada old value
    if (empty($oldValue) && $i == 0) {
        $selected = 'selected';
    } elseif ($oldValue == $tahunAjaran) {
        $selected = 'selected';
    }
    ?>
                                                <option value="<?= $tahunAjaran; ?>" <?= $selected; ?>><?= $tahunAjaran; ?></option>
                                             <?php } ?>
                                          </select>
                                          <?php if ($validation->hasError('tahun_ajaran')): ?>
                                             <div class="text-danger">
                                                <small><?= $validation->getError('tahun_ajaran'); ?></small>
                                             </div>
                                          <?php endif; ?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <!-- Submit Button -->
                     <div class="row">
                        <div class="col-md-12">
                           <div class="form-group mt-4 text-center">
                              <button type="submit" class="btn btn-success btn-round btn-lg">
                                 <i class="material-icons">save</i> Simpan Nilai
                              </button>
                              <a href="<?= base_url('admin/nilai/kelas/' . $siswa['id_kelas']); ?>" class="btn btn-warning btn-round btn-lg ml-3">
                                 <i class="material-icons">arrow_back</i> Kembali
                              </a>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
// Form validation and enhancement
document.addEventListener('DOMContentLoaded', function() {
    // Add input validation for nilai fields
    const nilaiInputs = document.querySelectorAll('input[type="number"][name*="nilai"]');
    
    nilaiInputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = parseFloat(this.value);
            if (value < 0) {
                this.value = 0;
            } else if (value > 100) {
                this.value = 100;
            }
        });
    });
    
    // Form submission validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const filledNilai = Array.from(nilaiInputs).filter(input => input.value.trim() !== '');
        
        if (filledNilai.length === 0) {
            e.preventDefault();
            alert('Harap isi minimal satu nilai mata pelajaran!');
            return false;
        }
    });
});
</script>

<?= $this->endSection() ?>
