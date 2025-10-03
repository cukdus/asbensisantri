<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-lg-12 col-md-12">
            <?php if (session()->getFlashdata('msg')) : ?>
               <div class="pb-2 px-3">
                  <div class="alert alert-<?= session()->getFlashdata('error') == true ? 'danger' : 'success'  ?> ">
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="material-icons">close</i>
                     </button>
                     <?= session()->getFlashdata('msg') ?>
                  </div>
               </div>
            <?php endif; ?>
            <div class="row">
               <div class="col-12 col-xl-12">
                  <div class="card">
                     <div class="card-header card-header-tabs card-header-success">
                        <div class="nav-tabs-navigation">
                           <div class="row">
                              <div class="col-md-4 col-lg-5">
                                 <h4 class="card-title"><b>Daftar Mata Pelajaran</b></h4>
                                 <p class="card-category">Tahun Ajaran <?= $generalSettings->school_year ?? '2024/2025'; ?></p>
                              </div>
                              <div class="ml-md-auto col-auto row">
                                 <div class="col-12 col-sm-auto nav nav-tabs">
                                    <div class="nav-item">
                                       <a class="nav-link" id="tabBtn" onclick="removeHover()" href="<?= base_url('admin/mapel/create'); ?>">
                                          <i class="material-icons">add</i> Tambah mata pelajaran
                                          <div class="ripple-container"></div>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-auto nav nav-tabs">
                                    <div class="nav-item">
                                       <a class="nav-link" id="refreshBtn" onclick="getDataMapel()" href="#" data-toggle="tab">
                                          <i class="material-icons">refresh</i> Refresh
                                          <div class="ripple-container"></div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="card-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="filterJurusan" class="bmd-label-floating">Filter Jurusan</label>
                                 <select class="form-control" id="filterJurusan" onchange="filterByJurusan()">
                                    <option value="">Semua Jurusan</option>
                                    <?php if (isset($jurusan) && is_array($jurusan)): ?>
                                       <?php foreach ($jurusan as $j): ?>
                                          <option value="<?= $j['id'] ?>"><?= $j['jurusan'] ?></option>
                                       <?php endforeach; ?>
                                    <?php endif; ?>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="filterKelas" class="bmd-label-floating">Filter Kelas</label>
                                 <select class="form-control" id="filterKelas" onchange="getDataMapel()">
                                    <option value="">Semua Kelas</option>
                                    <?php if (isset($kelas) && is_array($kelas)): ?>
                                       <?php foreach ($kelas as $k): ?>
                                          <option value="<?= $k['id_kelas'] ?>" data-jurusan="<?= $k['id_jurusan'] ?>"><?= $k['kelas'] ?> - <?= $k['jurusan'] ?></option>
                                       <?php endforeach; ?>
                                    <?php endif; ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="dataMapel">
                        <p class="text-center mt-3">Daftar mata pelajaran muncul disini</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function getDataMapel() {
      var kelasId = $("#filterKelas").val();
      var url = "<?= base_url('admin/mapel/ambil-data'); ?>";
      
      if (kelasId) {
         url += "?kelasId=" + kelasId;
      }
      
      $.ajax({
         url: url,
         type: "GET",
         success: function(data) {
            $("#dataMapel").html(data);
         },
         error: function() {
            $("#dataMapel").html('<div class="alert alert-danger">Gagal memuat data mata pelajaran</div>');
         }
      });
   }

   function filterByJurusan() {
      var jurusanId = $("#filterJurusan").val();
      var kelasSelect = $("#filterKelas");
      
      // Reset kelas selection
      kelasSelect.val("");
      
      // Show/hide kelas options based on jurusan
      kelasSelect.find("option").each(function() {
         var option = $(this);
         if (option.val() === "") {
            option.show(); // Always show "Semua Kelas" option
         } else if (jurusanId === "" || option.data("jurusan") == jurusanId) {
            option.show();
         } else {
            option.hide();
         }
      });
      
      // Refresh data
      getDataMapel();
   }

   function removeHover() {
      $("#tabBtn").removeClass("active");
   }

   $(document).ready(function() {
      getDataMapel();
   });
</script>
<?= $this->endSection() ?>