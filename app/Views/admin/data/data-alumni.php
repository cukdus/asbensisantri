<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header card-header-primary">
                  <div class="row">
                        <div class="col-md-4">
                           <h4 class="card-title"><b>Daftar Alumni</b></h4>
                           <p class="card-category">Siswa yang telah lulus</p>
                        </div>
                        <div class="col-md-8">
                           <div class="nav-tabs-wrapper">
                              <span class="nav-tabs-title">Tahun Lulus:</span>
                              <select class="form-control" id="tahun_lulus_filter" onchange="filterByTahunLulus()">
                                 <option value="">Semua Tahun</option>
                                 <?php foreach ($graduation_years as $value): ?>
                                    <?php if (!empty($value['tahun_lulus'])): ?>
                                       <option value="<?= $value['tahun_lulus']; ?>"><?= $value['tahun_lulus']; ?></option>
                                    <?php endif; ?>
                                 <?php endforeach; ?>
                              </select>
                           </div>
                        </div>
                     </div>
               </div>
               <div class="card-body">
                  <?php if (session()->getFlashdata('msg')): ?>
                     <div class="alert alert-<?= session()->getFlashdata('error') ? 'danger' : 'success'; ?> alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-<?= session()->getFlashdata('error') ? 'ban' : 'check'; ?>"></i></h4>
                        <?= session()->getFlashdata('msg') ?>
                     </div>
                  <?php endif; ?>

                  
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
   let tahun_lulus = null;

   function filterByTahunLulus() {
      const selectElement = document.getElementById('tahun_lulus_filter');
      tahun_lulus = selectElement.value || null;
      trig();
   }

   function trig() {
      $.ajax({
         url: "<?= base_url('admin/alumni/ambil-data-alumni'); ?>",
         type: "POST",
         data: {
            tahun_lulus: tahun_lulus
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