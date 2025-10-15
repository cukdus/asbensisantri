<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <?php if (session()->getFlashdata('msg')): ?>
               <div class="pb-2 px-3">
                  <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success' ?> ">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                     </button>
                     <?= session()->getFlashdata('msg') ?>
                  </div>
               </div>
            <?php endif; ?>
            
            <div class="card">
               <div class="card-header card-header-tabs card-header-success">
                  <div class="nav-tabs-navigation">
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="card-title"><b>Daftar Siswa - <?= $kelas->kelas ?> <?= $kelas->jurusan ?></b></h4>
                           <p class="card-category">Data Nilai Siswa</p>
                        </div>
                        <div class="col-md-6 text-right">
                           <a class="btn btn-primary" href="<?= base_url('admin/nilai'); ?>">
                              <i class="material-icons">arrow_back</i> Kembali ke Data Nilai
                           </a>
                        </div>
                     </div>
                  </div>
               </div>
               
               <div class="card-body table-responsive">
                  <?php if (!$empty): ?>
                     <table class="table table-hover">
                        <thead class="text-success">
                           <th><b>No</b></th>
                           <th><b>NIS</b></th>
                           <th><b>Nama Siswa</b></th>
                           <th><b>Kelas</b></th>
                           <th width="1%"><b>Aksi</b></th>
                        </thead>
                        <tbody>
                           <?php $i = 1;
    foreach ($siswaList as $siswa): ?>
                              <tr>
                                 <td><?= $i; ?></td>
                                 <td><?= $siswa['nis']; ?></td>
                                 <td><b><?= $siswa['nama_siswa']; ?></b></td>
                                 <td><?= $siswa['kelas']; ?> - <?= $siswa['jurusan']; ?></td>
                                 <td>
                                    <div class="d-flex justify-content-center">
                                       <a href="<?= base_url('admin/nilai/tambah-nilai-siswa/' . $siswa['id_siswa']); ?>" 
                                          class="btn btn-success btn-sm mr-2" 
                                          title="Tambah Nilai">
                                          <i class="material-icons">grade</i>
                                       </a>
                                       <a href="<?= base_url('admin/nilai/edit-nilai-siswa/' . $siswa['id_siswa']); ?>" 
                                          class="btn btn-warning btn-sm mr-2" 
                                          title="Edit Nilai">
                                          <i class="material-icons">edit</i>
                                       </a>
                                       <a href="<?= base_url('admin/nilai/lihat-nilai-siswa/' . $siswa['id_siswa']); ?>" 
                                          class="btn btn-info btn-sm" 
                                          title="Lihat Nilai">
                                          <i class="material-icons">visibility</i>
                                       </a>
                                    </div>
                                 </td>
                              </tr>
                              <?php $i++; ?>
                           <?php endforeach; ?>
                        </tbody>
                     </table>
                  <?php else: ?>
                     <div class="text-center py-5">
                        <i class="material-icons" style="font-size: 72px; color: #ccc;">school</i>
                        <h4 class="text-muted">Tidak ada siswa di kelas ini</h4>
                        <p class="text-muted">Belum ada data siswa yang terdaftar di kelas <?= $kelas->kelas ?> <?= $kelas->jurusan ?></p>
                     </div>
                  <?php endif; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?= $this->endSection() ?>