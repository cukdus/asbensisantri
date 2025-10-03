<h3 class="text-danger"><?= $msg; ?></h3>

<?php

use App\Libraries\enums\TipeUser;

if (empty($type)) {
    return;
} else {
    switch ($type) {
        case TipeUser::Siswa:
?>
         <div class="row w-100">
            <div class="col-md-3 text-center mb-3">
               <?php if (!empty($data['foto']) && file_exists(FCPATH . 'uploads/siswa/' . $data['foto'])): ?>
                  <img src="<?= base_url('uploads/siswa/' . $data['foto']); ?>" 
                       alt="Foto <?= $data['nama_siswa']; ?>" 
                       class="img-fluid rounded-circle border border-danger" 
                       style="width: 120px; height: 120px; object-fit: cover;">
               <?php else: ?>
                  <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                       style="width: 120px; height: 120px; margin: 0 auto;">
                     <i class="material-icons text-white" style="font-size: 60px;">person</i>
                  </div>
               <?php endif; ?>
            </div>
            <div class="col-md-6">
               <p>Nama : <b><?= $data['nama_siswa']; ?></b></p>
               <p>NIS : <b><?= $data['nis']; ?></b></p>
               <p>Kelas : <b><?= $data['kelas'] . ' ' . $data['jurusan']; ?></b></p>
            </div>
            <div class="col-md-3">
               <?= jam($presensi ?? []); ?>
            </div>
         </div>
      <?php break;

        case TipeUser::Guru: ?>
         <div class="row w-100">
            <div class="col">
               <p>Nama : <b><?= $data['nama_guru']; ?></b></p>
               <p>NUPTK : <b><?= $data['nuptk']; ?></b></p>

            </div>
            <div class="col">
               <?= jam($presensi ?? []); ?>
            </div>
         </div>
      <?php break;

        default: ?>
         <p class="text-danger">Tipe tidak valid</p>
   <?php
            break;
    }
}

function jam($presensi)
{
?>
   <p>Jam masuk : <b class="text-info"><?= $presensi['jam_masuk'] ?? '-'; ?></b></p>
   <p>Jam pulang : <b class="text-info"><?= $presensi['jam_keluar'] ?? '-'; ?></b></p>
<?php
}

?>