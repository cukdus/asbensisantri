<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-success">
                  <h4 class="card-title"><b>Form Tambah Nilai Siswa</b></h4>
               </div>
               <div class="card-body mx-5 my-3">

                  <?php if (session()->getFlashdata('msg')) : ?>
                     <div class="pb-2">
                        <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success'  ?> ">
                           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <i class="material-icons">close</i>
                           </button>
                           <?= session()->getFlashdata('msg') ?>
                        </div>
                     </div>
                  <?php endif; ?>

                  <form action="<?= base_url('admin/nilai/create'); ?>" method="post">
                     <?= csrf_field() ?>
                     <?php $validation = \Config\Services::validation(); ?>

                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group mt-4">
                              <label for="id_siswa">Siswa</label>
                              <select id="id_siswa" class="form-control <?= $validation->getError('id_siswa') ? 'is-invalid' : ''; ?>" name="id_siswa" required>
                                 <option value="">-- Pilih Siswa --</option>
                                 <?php foreach ($siswaList as $s): ?>
                                    <option value="<?= $s['id_siswa']; ?>" <?= old('id_siswa') == $s['id_siswa'] ? 'selected' : ''; ?>>
                                       <?= $s['nama_siswa']; ?> (<?= $s['nis']; ?>)
                                    </option>
                                 <?php endforeach; ?>
                              </select>
                              <div class="invalid-feedback">
                                 <?= $validation->getError('id_siswa'); ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="form-group mt-4">
                              <label for="id_mapel">Mata Pelajaran</label>
                              <select id="id_mapel" class="form-control <?= $validation->getError('id_mapel') ? 'is-invalid' : ''; ?>" name="id_mapel" required>
                                 <option value="">-- Pilih Mata Pelajaran --</option>
                                 <?php foreach ($mapelList as $m): ?>
                                    <option value="<?= $m['id_mapel']; ?>" <?= old('id_mapel') == $m['id_mapel'] ? 'selected' : ''; ?>>
                                       <?= $m['nama_mapel']; ?>
                                    </option>
                                 <?php endforeach; ?>
                              </select>
                              <div class="invalid-feedback">
                                 <?= $validation->getError('id_mapel'); ?>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-4">
                           <div class="form-group mt-4">
                              <label for="nilai">Nilai</label>
                              <input type="number" id="nilai" class="form-control <?= $validation->getError('nilai') ? 'is-invalid' : ''; ?>" name="nilai" placeholder="0-100" min="0" max="100" step="0.01" value="<?= old('nilai') ?>" required>
                              <div class="invalid-feedback">
                                 <?= $validation->getError('nilai'); ?>
                              </div>
                              <small class="form-text text-muted">Nilai antara 0 sampai 100</small>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group mt-4">
                              <label for="semester">Semester</label>
                              <select id="semester" class="form-control <?= $validation->getError('semester') ? 'is-invalid' : ''; ?>" name="semester" required>
                                 <option value="">-- Pilih Semester --</option>
                                 <option value="1" <?= old('semester') == '1' ? 'selected' : ''; ?>>Semester 1</option>
                                 <option value="2" <?= old('semester') == '2' ? 'selected' : ''; ?>>Semester 2</option>
                              </select>
                              <div class="invalid-feedback">
                                 <?= $validation->getError('semester'); ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="form-group mt-4">
                              <label for="tahun_ajaran">Tahun Ajaran</label>
                              <select id="tahun_ajaran" class="form-control <?= $validation->getError('tahun_ajaran') ? 'is-invalid' : ''; ?>" name="tahun_ajaran" required>
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
                              <div class="invalid-feedback">
                                 <?= $validation->getError('tahun_ajaran'); ?>
                              </div>
                              <small class="form-text text-muted">Pilih tahun ajaran yang sesuai</small>
                           </div>
                        </div>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <button type="submit" class="btn btn-success">
                              <i class="material-icons">save</i> Simpan
                           </button>
                           <a href="<?= base_url('admin/nilai'); ?>" class="btn btn-secondary">
                              <i class="material-icons">arrow_back</i> Kembali
                           </a>
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
$(document).ready(function() {
    // Auto-fill current academic year
    if (!$('#tahun_ajaran').val()) {
        const currentYear = new Date().getFullYear();
        const nextYear = currentYear + 1;
        $('#tahun_ajaran').val(currentYear + '/' + nextYear);
    }
});
</script>
<?= $this->endSection() ?>