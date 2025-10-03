<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <div class="card">
               <div class="card-header card-header-success">
                  <h4 class="card-title"><b>Form Edit Mata Pelajaran</b></h4>
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

                  <form action="<?= base_url('admin/mapel/update'); ?>" method="post">
                     <?= csrf_field() ?>
                     <input type="hidden" name="_method" value="PUT">
                     <input type="hidden" name="id_mapel" value="<?= $data['id_mapel']; ?>">
                     <?php $validation = \Config\Services::validation(); ?>

                     <div class="form-group mt-4">
                        <label for="nama_mapel">Nama Mata Pelajaran</label>
                        <input type="text" id="nama_mapel" class="form-control <?= $validation->getError('nama_mapel') ? 'is-invalid' : ''; ?>" name="nama_mapel" placeholder="Contoh: Matematika" value="<?= old('nama_mapel') ?? $data['nama_mapel']; ?>" required>
                        <div class="invalid-feedback">
                           <?= $validation->getError('nama_mapel'); ?>
                        </div>
                     </div>

                     <div class="form-group mt-4">
                        <label for="id_kelas">Kelas</label>
                        <select id="id_kelas" class="form-control <?= $validation->getError('id_kelas') ? 'is-invalid' : ''; ?>" name="id_kelas">
                           <option value="">-- Pilih Kelas (Opsional) --</option>
                           <?php if (isset($kelas) && is_array($kelas)): ?>
                              <?php foreach ($kelas as $k): ?>
                                 <option value="<?= $k['id_kelas']; ?>" <?= (old('id_kelas') ?? $mapel['id_kelas']) == $k['id_kelas'] ? 'selected' : ''; ?>>
                                    <?= $k['kelas']; ?> - <?= $k['jurusan']; ?>
                                 </option>
                              <?php endforeach; ?>
                           <?php endif; ?>
                        </select>
                        <div class="invalid-feedback">
                           <?= $validation->getError('id_kelas'); ?>
                        </div>
                        <small class="form-text text-muted">Kosongkan jika mata pelajaran untuk semua kelas</small>
                     </div>

                     <div class="form-group mt-4">
                        <label for="user_id">Guru Pengampu</label>
                        <select id="user_id" class="form-control <?= $validation->getError('user_id') ? 'is-invalid' : ''; ?>" name="user_id">
                           <option value="">-- Pilih Guru (Opsional) --</option>
                           <?php foreach ($guru as $g): ?>
                              <option value="<?= $g['id']; ?>" <?= (old('user_id') ?? $mapel['user_id']) == $g['id'] ? 'selected' : ''; ?>>
                                 <?= $g['nama_lengkap']; ?> (<?= $g['nuptk']; ?>)
                              </option>
                           <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                           <?= $validation->getError('user_id'); ?>
                        </div>
                        <small class="form-text text-muted">Guru pengampu dapat diatur nanti jika belum ditentukan</small>
                     </div>

                     <div class="row">
                        <div class="col-md-6">
                           <button type="submit" class="btn btn-success">
                              <i class="material-icons">save</i> Update
                           </button>
                           <a href="<?= base_url('admin/mapel'); ?>" class="btn btn-secondary">
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