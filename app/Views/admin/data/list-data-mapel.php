<div class="card-body table-responsive">
   <?php if (!$empty): ?>
      <table class="table table-hover">
         <thead class="text-success">
            <th><b>No</b></th>
            <th><b>Nama Mata Pelajaran</b></th>
            <th><b>Kelas</b></th>
            <th><b>Guru Pengampu</b></th>
            <th width="1%"><b>Aksi</b></th>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value): ?>
               <tr>
                  <td><?= $i; ?></td>
                  <td><b><?= $value['nama_mapel']; ?></b></td>
                  <td>
                        <?php if (isset($value['kelas']) && isset($value['jurusan'])): ?>
                           <span class="badge badge-info"><?= $value['kelas']; ?> - <?= $value['jurusan']; ?></span>
                        <?php else: ?>
                           <span class="badge badge-secondary">Semua Kelas</span>
                        <?php endif; ?>
                     </td>
                  <td><?= $value['nama_guru'] ?? '<span class="text-muted">Belum ditentukan</span>'; ?></td>
                  <td>
                     <div class="d-flex justify-content-center">
                        <a title="Edit" href="<?= base_url('admin/mapel/edit/' . $value['id_mapel']); ?>" class="btn btn-success p-2">
                           <i class="material-icons">edit</i>
                        </a>
                        <form action="<?= base_url('admin/mapel/delete/' . $value['id_mapel']); ?>" method="post" class="d-inline">
                           <?= csrf_field(); ?>
                           <input type="hidden" name="_method" value="DELETE">
                           <button title="Delete" onclick="return confirm('Konfirmasi untuk menghapus mata pelajaran ini?');" type="submit" class="btn btn-danger p-2">
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
            <h4 class="text-center text-danger">Data mata pelajaran tidak ditemukan</h4>
         </div>
      </div>
   <?php endif; ?>
</div>