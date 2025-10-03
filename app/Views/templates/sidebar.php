<?php
$context = $ctx ?? 'dashboard';
switch ($context) {
    case 'absen-siswa':
    case 'siswa':
    case 'kelas':
        $sidebarColor = 'purple';
        break;
    case 'absen-guru':
    case 'guru':
        $sidebarColor = 'green';
        break;

    case 'qr':
        $sidebarColor = 'danger';
        break;

    default:
        $sidebarColor = 'azure';
        break;
}
?>
<div class="sidebar" data-color="<?= $sidebarColor; ?>" data-background-color="black" data-image="<?= base_url('assets/img/sidebar/sidebar-1.jpg'); ?>">
   <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
   <div class="logo">
      <a class="simple-text logo-normal">
         <b>Operator<br>Petugas Absensi</b>
      </a>
   </div>
   <div class="sidebar-wrapper">
      <ul class="nav">
         <li class="nav-item <?= $context == 'dashboard' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>">
               <i class="material-icons">dashboard</i>
               <p>Dashboard</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'absen-siswa' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/absen-siswa'); ?>">
               <i class="material-icons">checklist</i>
               <p>Absensi Siswa</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'absen-guru' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/absen-guru'); ?>">
               <i class="material-icons">checklist</i>
               <p>Absensi Guru</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'siswa' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/siswa'); ?>">
               <i class="material-icons">person</i>
               <p>Data Siswa</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'alumni' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/alumni'); ?>">
               <i class="material-icons">school</i>
               <p>Data Alumni</p>
            </a>
         </li>
         <?php
$user = user();
$userRole = $user->role ?? ($user->is_superadmin ? 'superadmin' : 'guru');
?>
         <?php if ($userRole === 'superadmin'): ?>
            <li class="nav-item <?= $context == 'user' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/user'); ?>">
                  <i class="material-icons">person_4</i>
                  <p>Data Guru</p>
               </a>
            </li>
         <?php endif; ?>
         <li class="nav-item <?= $context == 'mapel' ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('admin/mapel'); ?>">
               <i class="material-icons">book</i>
               <p>Data Mata Pelajaran</p>
            </a>
         </li>
         <li class="nav-item <?= $context == 'nilai' ? 'active' : ''; ?>">
            <a class="nav-link" data-toggle="collapse" href="#nilaiSubmenu" role="button" aria-expanded="false" aria-controls="nilaiSubmenu">
               <i class="material-icons">grade</i>
               <p>Data Nilai Siswa
                  <b class="caret"></b>
               </p>
            </a>
            <div class="collapse <?= $context == 'nilai' ? 'show' : ''; ?>" id="nilaiSubmenu">
               <ul class="nav">
                  <li class="nav-item">
                     <a class="nav-link" href="<?= base_url('admin/nilai'); ?>">
                        <span class="sidebar-mini"> DN </span>
                        <span class="sidebar-normal"> Data Nilai </span>
                     </a>
                  </li>
                  <?php
// Load KelasModel to get all classes
$kelasModel = new \App\Models\KelasModel();
$kelasList = $kelasModel->getAllKelas();
?>
                  <?php foreach ($kelasList as $kelas): ?>
                     <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/nilai/kelas/' . $kelas['id_kelas']); ?>">
                           <span class="sidebar-mini"> <?= substr($kelas['kelas'], 0, 2); ?> </span>
                           <span class="sidebar-normal"> <?= $kelas['kelas'] . ' - ' . $kelas['jurusan']; ?> </span>
                        </a>
                     </li>
                  <?php endforeach; ?>
               </ul>
            </div>
         </li>
         <?php if ($userRole === 'superadmin'): ?>
            <li class="nav-item <?= $context == 'kelas' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/kelas'); ?>">
                  <i class="material-icons">school</i>
                  <p>Data Kelas & Jurusan</p>
               </a>
            </li>
         <?php endif; ?>
         <?php if ($userRole === 'superadmin'): ?>
            <li class="nav-item <?= $context == 'qr' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/generate'); ?>">
                  <i class="material-icons">qr_code</i>
                  <p>Generate QR Code</p>
               </a>
            </li>
            <li class="nav-item <?= $context == 'laporan' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/laporan'); ?>">
                  <i class="material-icons">print</i>
                  <p>Generate Laporan</p>
               </a>
            </li>
         <?php endif; ?>
         <?php if ($userRole === 'superadmin'): ?>
            <li class="nav-item <?= $context == 'general_settings' ? 'active' : ''; ?>">
               <a class="nav-link" href="<?= base_url('admin/general-settings'); ?>">
                  <i class="material-icons">settings</i>
                  <p>Pengaturan</p>
               </a>
            </li>
         <?php endif; ?>
         <!-- <li class="nav-item active-pro mb-3">
            <a class="nav-link" href="./upgrade.html">
               <i class="material-icons">unarchive</i>
               <p>Bottom sidebar</p>
            </a>
         </li> -->
      </ul>
   </div>
</div>