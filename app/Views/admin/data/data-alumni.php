<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <h4 class="card-title"><b>Data Alumni</b></h4>
                  <p class="card-category">Daftar siswa yang telah lulus</p>
               </div>
               <div class="card-body">
                  <?php if (session()->getFlashdata('msg')): ?>
                     <div class="alert alert-<?= session()->getFlashdata('error') ? 'danger' : 'success'; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-<?= session()->getFlashdata('error') ? 'ban' : 'check'; ?>"></i></h4>
                        <?= session()->getFlashdata('msg') ?>
                     </div>
                  <?php endif; ?>

                  <div class="nav-tabs-navigation">
                     <div class="row">
                        <div class="col-md-2">
                           <h4 class="card-title"><b>Daftar Alumni</b></h4>
                           <p class="card-category">Siswa yang telah lulus</p>
                        </div>
                        <div class="col-md-4">
                           <div class="nav-tabs-wrapper">
                              <span class="nav-tabs-title">Kelas:</span>
                              <ul class="nav nav-tabs" data-tabs="tabs">
                                 <li class="nav-item">
                                    <a class="nav-link active" onclick="kelas = null; trig()" href="#" data-toggle="tab">
                                       <i class="material-icons">check</i> Semua
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                                 <?php
$tempKelas = [];
foreach ($kelas as $value):
?>
                                    <?php if (!in_array($value['kelas'], $tempKelas)): ?>
                                       <li class="nav-item">
                                          <a class="nav-link" onclick="kelas = '<?= $value['kelas']; ?>'; trig()" href="#" data-toggle="tab">
                                             <i class="material-icons">school</i> <?= $value['kelas']; ?>
                                             <div class="ripple-container"></div>
                                          </a>
                                       </li>
                                       <?php array_push($tempKelas, $value['kelas']) ?>
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                              </ul>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="nav-tabs-wrapper">
                              <span class="nav-tabs-title">Jurusan:</span>
                              <ul class="nav nav-tabs" data-tabs="tabs">
                                 <li class="nav-item">
                                    <a class="nav-link active" onclick="jurusan = null; trig()" href="#" data-toggle="tab">
                                       <i class="material-icons">check</i> Semua
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                                 <?php foreach ($jurusan as $value): ?>
                                    <li class="nav-item">
                                       <a class="nav-link" onclick="jurusan = '<?= $value['jurusan']; ?>'; trig()" href="#" data-toggle="tab">
                                          <i class="material-icons">work</i> <?= $value['jurusan']; ?>
                                          <div class="ripple-container"></div>
                                       </a>
                                    </li>
                                 <?php endforeach; ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-content">
                     <div class="tab-pane active" id="link1">
                        <div class="card-body">
                           <div class="toolbar">
                              <div class="row">
                                 <div class="col-md-6">
                                    <a href="<?= base_url('admin/siswa'); ?>" class="btn btn-info btn-sm">
                                       <i class="material-icons">arrow_back</i> Kembali ke Data Siswa
                                    </a>
                                 </div>
                                 <div class="col-md-6 text-right">
                                    <button class="btn btn-primary btn-sm" onclick="printTable()">
                                       <i class="material-icons">print</i> Cetak Data Alumni
                                    </button>
                                 </div>
                              </div>
                           </div>
                           <div class="material-datatables">
                              <div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div id="load-table">
                                          <!-- Table will be loaded here via AJAX -->
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   let kelas = null;
   let jurusan = null;

   function trig() {
      $.ajax({
         url: "<?= base_url('admin/alumni/ambil-data-alumni'); ?>",
         type: "POST",
         data: {
            kelas: kelas,
            jurusan: jurusan
         },
         success: function(data) {
            $("#load-table").html(data);
         },
         error: function() {
            $("#load-table").html('<div class="alert alert-danger">Gagal memuat data alumni</div>');
         }
      });
   }

   function printTable() {
      var printContents = document.getElementById('load-table').innerHTML;
      var originalContents = document.body.innerHTML;
      
      document.body.innerHTML = '<h2>Data Alumni</h2>' + printContents;
      window.print();
      document.body.innerHTML = originalContents;
      location.reload();
   }

   // Load data on page load
   $(document).ready(function() {
      trig();
   });
</script>

<?= $this->endSection() ?>