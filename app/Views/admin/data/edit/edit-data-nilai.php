<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-success">
                  <h4 class="card-title"><b>Form Edit Nilai Siswa</b></h4>
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

                  <form action="<?= base_url('admin/nilai/edit'); ?>" method="post">
                     <?= csrf_field() ?>
                     <input type="hidden" name="id_nilai" value="<?= $nilai['id_nilai']; ?>">
                     <?php $validation = \Config\Services::validation(); ?>

                     <div class="row">
                        <div class="col-md-6">
                           <div class="form-group mt-4">
                              <label for="id_siswa">Siswa</label>
                              <select id="id_siswa" class="form-control <?= $validation->getError('id_siswa') ? 'is-invalid' : ''; ?>" name="id_siswa" required>
                                 <option value="">-- Pilih Siswa --</option>
                                 <?php foreach ($siswaList as $s): ?>
                                    <option value="<?= $s['id_siswa']; ?>" <?= (old('id_siswa') ?? $nilai['id_siswa']) == $s['id_siswa'] ? 'selected' : ''; ?>>
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
                                    <option value="<?= $m['id_mapel']; ?>" <?= (old('id_mapel') ?? $nilai['id_mapel']) == $m['id_mapel'] ? 'selected' : ''; ?>>
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
                              <input type="number" id="nilai" class="form-control <?= $validation->getError('nilai') ? 'is-invalid' : ''; ?>" name="nilai" placeholder="0-100" min="0" max="100" step="1" value="<?= old('nilai') ?? $nilai['nilai']; ?>" required>
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
                                 <?php
$currentSemester = old('semester') ?? $nilai['semester'];
// Debug: uncomment line below to see the actual value
// echo "<!-- Debug: Current semester = '$currentSemester', Type: " . gettype($currentSemester) . " -->";
?>
                                 <option value="1" <?= ($currentSemester == '1' || $currentSemester == 1 || $currentSemester === 1) ? 'selected' : ''; ?>>Semester 1</option>
                                 <option value="2" <?= ($currentSemester == '2' || $currentSemester == 2 || $currentSemester === 2) ? 'selected' : ''; ?>>Semester 2</option>
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
$oldValue = old('tahun_ajaran') ?? $nilai['tahun_ajaran'];

// Generate tahun ajaran dari 2 tahun kebelakang sampai 2 tahun kedepan
for ($i = -2; $i <= 2; $i++) {
    $startYear = $currentYear + $i;
    $endYear = $startYear + 1;
    $tahunAjaran = $startYear . '/' . $endYear;
    $selected = '';

    // Set selected berdasarkan data yang ada atau old value
    if ($oldValue == $tahunAjaran) {
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
                              <i class="material-icons">save</i> Update
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
<?= $this->endSection() ?>