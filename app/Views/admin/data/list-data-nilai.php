<div class="card-body table-responsive">
   <?php if (!$empty): ?>
      <table class="table table-hover">
         <thead class="text-success">
            <th><b>No</b></th>
            <th><b>Nama Siswa</b></th>
            <th><b>NIS</b></th>
            <th><b>Mata Pelajaran</b></th>
            <th><b>Nilai</b></th>
            <th><b>Semester</b></th>
            <th><b>Tahun Ajaran</b></th>
            <th><b>Tanggal Input</b></th>
            <th width="1%"><b>Aksi</b></th>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value): ?>
               <tr>
                  <td><?= $i; ?></td>
                  <td><b><?= $value['nama_siswa']; ?></b></td>
                  <td><?= $value['nis']; ?></td>
                  <td><?= $value['nama_mapel']; ?></td>
                  <td>
                     <span class="badge badge-<?= $value['nilai'] >= 75 ? 'success' : ($value['nilai'] >= 60 ? 'warning' : 'danger'); ?>">
                        <?= $value['nilai']; ?>
                     </span>
                  </td>
                  <td>Semester <?= $value['semester']; ?></td>
                  <td><?= $value['tahun_ajaran']; ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($value['created_at'])); ?></td>
                  <td>
                     <div class="d-flex justify-content-center">
                        <a title="Edit" href="<?= base_url('admin/nilai/edit/' . $value['id_nilai']); ?>" class="btn btn-success p-2">
                           <i class="material-icons">edit</i>
                        </a>
                        <form action="<?= base_url('admin/nilai/delete/' . $value['id_nilai']); ?>" method="post" class="d-inline">
                           <?= csrf_field(); ?>
                           <input type="hidden" name="_method" value="DELETE">
                           <button title="Delete" onclick="return confirm('Konfirmasi untuk menghapus nilai ini?');" type="submit" class="btn btn-danger p-2">
                              <i class="material-icons">delete_forever</i>
                           </button>
                        </form>
                     </div>
                  </td>
               </tr>
            <?php $i++;
            endforeach; ?>
         </tbody>
      </table>
   <?php else: ?>
      <div class="row">
         <div class="col">
            <h4 class="text-center text-danger">Data nilai tidak ditemukan</h4>
            <p class="text-center text-muted">Gunakan filter di atas untuk mencari data atau tambah data nilai baru</p>
         </div>
      </div>
   <?php endif; ?>
</div>