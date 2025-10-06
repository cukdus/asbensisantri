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
            <?php
            $startNumber = isset($pagination) ? (($pagination['current_page'] - 1) * $pagination['per_page']) + 1 : 1;
            $i = $startNumber;
            foreach ($data as $value):
                ?>
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
      
      <!-- Pagination Controls -->
      <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
         <div class="row mt-3">
            <div class="col-md-6">
               <p class="text-muted">
                  Menampilkan <?= count($data); ?> dari <?= $pagination['total_data']; ?> data 
                  (Halaman <?= $pagination['current_page']; ?> dari <?= $pagination['total_pages']; ?>)
               </p>
            </div>
            <div class="col-md-6">
               <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-end">
                     <!-- Previous Button -->
                     <li class="page-item <?= !$pagination['has_prev'] ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" onclick="<?= $pagination['has_prev'] ? 'changePage(' . $pagination['prev_page'] . ')' : 'return false;'; ?>">
                           <i class="material-icons">chevron_left</i>
                        </a>
                     </li>
                     
                     <!-- Page Numbers -->
                     <?php
        $start = max(1, $pagination['current_page'] - 2);
        $end = min($pagination['total_pages'], $pagination['current_page'] + 2);

        for ($i = $start; $i <= $end; $i++):
            ?>
                        <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : ''; ?>">
                           <a class="page-link" href="#" onclick="changePage(<?= $i; ?>)"><?= $i; ?></a>
                        </li>
                     <?php endfor; ?>
                     
                     <!-- Next Button -->
                     <li class="page-item <?= !$pagination['has_next'] ? 'disabled' : ''; ?>">
                        <a class="page-link" href="#" onclick="<?= $pagination['has_next'] ? 'changePage(' . $pagination['next_page'] . ')' : 'return false;'; ?>">
                           <i class="material-icons">chevron_right</i>
                        </a>
                     </li>
                  </ul>
               </nav>
            </div>
         </div>
      <?php endif; ?>
      
   <?php else: ?>
      <div class="row">
         <div class="col">
            <h4 class="text-center text-danger">Data nilai tidak ditemukan</h4>
            <p class="text-center text-muted">Gunakan filter di atas untuk mencari data atau tambah data nilai baru</p>
         </div>
      </div>
   <?php endif; ?>
</div>