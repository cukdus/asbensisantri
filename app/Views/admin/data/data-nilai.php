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
            
            <!-- Filter Card -->
            <div class="row mb-3">
               <div class="col-12">
                  <div class="card">
                     <div class="card-header card-header-info">
                        <h4 class="card-title"><b>Filter Data Nilai</b></h4>
                     </div>
                     <div class="card-body">
                        <form id="filterForm">
                           <div class="row">
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="filter_mapel">Mata Pelajaran</label>
                                    <select id="filter_mapel" class="form-control" name="mapel_id">
                                       <option value="">-- Semua Mata Pelajaran --</option>
                                       <?php foreach ($mapel as $m): ?>
                                          <option value="<?= $m['id_mapel']; ?>"><?= $m['nama_mapel']; ?></option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="filter_siswa">Siswa</label>
                                    <select id="filter_siswa" class="form-control" name="siswa_id">
                                       <option value="">-- Semua Siswa --</option>
                                       <?php foreach ($siswa as $s): ?>
                                          <option value="<?= $s['id_siswa']; ?>"><?= $s['nama_siswa']; ?> (<?= $s['nis']; ?>)</option>
                                       <?php endforeach; ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="filter_semester">Semester</label>
                                    <select id="filter_semester" class="form-control" name="semester">
                                       <option value="">-- Semua Semester --</option>
                                       <option value="1">Semester 1</option>
                                       <option value="2">Semester 2</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="filter_tahun">Tahun Ajaran</label>
                                    <select id="filter_tahun" class="form-control" name="tahun_ajaran">
                                       <option value="">Semua Tahun</option>
                                       <?php 
                                          $currentYear = date('Y');
                                          // Generate tahun ajaran dari 2 tahun kebelakang sampai 2 tahun kedepan
                                          for ($i = -2; $i <= 2; $i++) {
                                             $startYear = $currentYear + $i;
                                             $endYear = $startYear + 1;
                                             $tahunAjaran = $startYear . '/' . $endYear;
                                       ?>
                                          <option value="<?= $tahunAjaran; ?>"><?= $tahunAjaran; ?></option>
                                       <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                       <button type="button" onclick="getDataNilai()" class="btn btn-info btn-sm">
                                          <i class="material-icons">search</i> Filter
                                       </button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>

            <div class="row">
               <div class="col-12 col-xl-12">
                  <div class="card">
                     <div class="card-header card-header-tabs card-header-success">
                        <div class="nav-tabs-navigation">
                           <div class="row">
                              <div class="col-md-4 col-lg-5">
                                 <h4 class="card-title"><b>Daftar Nilai Siswa</b></h4>
                                 <p class="card-category">Tahun Ajaran <?= $generalSettings->school_year ?? '2024/2025'; ?></p>
                              </div>
                              <div class="ml-md-auto col-auto row">
                                 <div class="col-12 col-sm-auto nav nav-tabs">
                                    <div class="nav-item">
                                       <a class="nav-link" id="tabBtn" onclick="removeHover()" href="<?= base_url('admin/nilai/create'); ?>">
                                          <i class="material-icons">add</i> Tambah nilai
                                          <div class="ripple-container"></div>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-auto nav nav-tabs">
                                    <div class="nav-item">
                                       <a class="nav-link" onclick="getDataNilai()" href="#" data-toggle="tab">
                                          <i class="material-icons">refresh</i> Refresh
                                          <div class="ripple-container"></div>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="col-12 col-sm-auto nav nav-tabs">
                                    <div class="nav-item">
                                       <a class="nav-link" href="<?= base_url('admin/nilai/statistik'); ?>" data-toggle="tab">
                                          <i class="material-icons">bar_chart</i> Statistik
                                          <div class="ripple-container"></div>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="dataNilai">
                        <p class="text-center mt-3">Daftar nilai muncul disini</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   function getDataNilai() {
      const formData = new FormData(document.getElementById('filterForm'));
      const params = new URLSearchParams(formData).toString();
      
      $.ajax({
         url: "<?= base_url('admin/nilai/ambil-data'); ?>" + (params ? '?' + params : ''),
         type: "GET",
         success: function(data) {
            $("#dataNilai").html(data);
         },
         error: function() {
            $("#dataNilai").html('<div class="alert alert-danger">Gagal memuat data nilai</div>');
         }
      });
   }

   function removeHover() {
      $("#tabBtn").removeClass("active");
   }

   $(document).ready(function() {
      getDataNilai();
   });
</script>
<?= $this->endSection() ?>