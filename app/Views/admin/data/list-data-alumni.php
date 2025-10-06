<div class="card-body table-responsive">
   <?php if (!$empty): ?>
      <table class="table table-hover">
         <thead class="text-primary">
            <th><b>No</b></th>
            <th><b>NIS</b></th>
            <th><b>Foto</b></th>
            <th><b>Nama</b></th>
            <th><b>Tahun Masuk</b></th>
            <th><b>Tahun Lulus</b></th>
            <th><b>Status</b></th>
            <th width="1%"><b>Aksi</b></th>
         </thead>
         <tbody>
            <?php $i = 1;
            foreach ($data as $value): ?>
               <tr>
                  <td><?= $i; ?></td>
                  <td><?= $value['nis']; ?></td>
                  <td><?php if (!empty($value['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $value['foto'])): ?>
                           <img src="<?= base_url('uploads/siswa/' . $value['foto']); ?>" 
                                alt="Foto <?= $value['nama_siswa']; ?>" 
                                class="rounded-circle me-2" 
                                style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                        <?php else: ?>
                           <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" 
                                style="width: 40px; height: 40px; margin-right: 10px;">
                              <i class="material-icons text-muted" style="font-size: 20px;">school</i>
                           </div>
                        <?php endif; ?></td>
                  <td>
                     
                        <b><?= $value['nama_siswa']; ?></b>

                  </td>
                  <td><?= $value['tahun_masuk'] ?? '-'; ?></td>
                  <td><?= $value['tahun_lulus'] ?? '-'; ?></td>
                  <td>
                     <span class="badge badge-success" id="status-badge-<?= $value['id_siswa']; ?>">
                        Lulus
                     </span>
                  </td>
                  <td>
                     <div class="d-flex justify-content-center">
                        <a title="Lihat Detail" href="<?= base_url('admin/alumni/view/' . $value['id_siswa']); ?>" class="btn btn-info p-2">
                           <i class="material-icons">visibility</i>
                        </a>
                        <button title="Aktifkan Kembali" onclick="toggleGraduationStatus(<?= $value['id_siswa']; ?>)" class="btn btn-warning p-2" id="toggle-btn-<?= $value['id_siswa']; ?>">
                           <i class="material-icons">restore</i>
                        </button>
                        <a title="Download QR Code" href="<?= base_url('admin/qr/siswa/' . $value['id_siswa'] . '/download'); ?>" class="btn btn-success p-2">
                           <i class="material-icons">qr_code</i>
                        </a>
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
            <div class="text-center py-5">
               <i class="material-icons" style="font-size: 80px; color: #ccc;">school</i>
               <h4 class="text-muted mt-3">Belum ada data alumni</h4>
               <p class="text-muted">Data alumni akan muncul setelah ada siswa yang diluluskan</p>
            </div>
         </div>
      </div>
   <?php endif; ?>
</div>

<script>
function toggleGraduationStatus(id_siswa) {
    if (confirm('Apakah Anda yakin ingin mengaktifkan kembali alumni ini menjadi siswa aktif?')) {
        $.ajax({
            url: "<?= base_url('admin/alumni/toggle-graduation-status'); ?>",
            type: "POST",
            data: {
                id_siswa: id_siswa,
                <?= csrf_token(); ?>: "<?= csrf_hash(); ?>"
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    // Reload the table
                    trig();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat mengubah status kelulusan');
            }
        });
    }
}
</script>