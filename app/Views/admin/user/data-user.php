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
            <?php if ($userRole === 'superadmin'): ?>
               <a class="btn btn-primary ml-3 pl-3 py-3" href="<?= base_url('admin/user/register'); ?>">
                  <i class="material-icons mr-2">add</i> Tambah User
               </a>
               <button class="btn btn-danger ml-3 pl-3 py-3 btn-table-delete" onclick="deleteSelectedUsers('Data yang sudah dihapus tidak bisa dikembalikan');"><i class="material-icons mr-2">delete_forever</i>Bulk Delete</button>
            <?php else: ?>
               <div class="alert alert-info ml-3 mr-3">
                  <i class="material-icons mr-2">info</i>
                  <strong>Mode Lihat Saja:</strong> Anda dapat melihat data user dan mendownload QR Code guru, tetapi tidak dapat mengedit atau menghapus data.
               </div>
            <?php endif; ?>
            <div class="card">
               <div class="card-header card-header-tabs card-header-primary">
                  <div class="nav-tabs-navigation">
                     <div class="row">
                        <div class="col-md-6">
                           <h4 class="card-title"><b><?= $ctx === 'guru' ? 'Daftar Guru' : 'Daftar User' ?></b></h4>
                           <p class="card-category"><?= $ctx === 'guru' ? 'Data Guru' : 'Guru & Petugas Sistem' ?></p>
                        </div>
                        <div class="col-md-6">
                           <?php if ($ctx === 'user'): ?>
                           <div class="nav-tabs-wrapper">
                              <span class="nav-tabs-title">Filter Role:</span>
                              <ul class="nav nav-tabs" data-tabs="tabs">
                                 <li class="nav-item">
                                    <a class="nav-link active" onclick="role = null; triggerFilter()" href="#" data-toggle="tab">
                                       <i class="material-icons">check</i> Semua
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" onclick="role = 'guru'; triggerFilter()" href="#" data-toggle="tab">
                                       <i class="material-icons">school</i> Guru
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                                 <li class="nav-item">
                                    <a class="nav-link" onclick="role = 'superadmin'; triggerFilter()" href="#" data-toggle="tab">
                                       <i class="material-icons">admin_panel_settings</i> Admin
                                       <div class="ripple-container"></div>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               </div>
               <div id="list-data-user">
                  <p class="text-center mt-3">Daftar user muncul disini</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   var role = null;

   $(document).ready(function() {
      getDataUser();
   });

   function getDataUser() {
      $.ajax({
         url: '<?= base_url('admin/user') ?>',
         type: 'POST',
         data: {
            role: role
         },
         success: function(response) {
            $('#list-data-user').html(response);
            // Add event handler for checkAll after data is loaded
            $('#checkAll').on('change', function() {
               checkAll();
            });
         },
         error: function() {
            $('#list-data-user').html('<div class="alert alert-danger">Gagal memuat data user</div>');
         }
      });
   }

   function triggerFilter() {
      getDataUser();
   }

   function deleteUser(id) {
      if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
         $.ajax({
            url: '<?= base_url('admin/user/delete/') ?>' + id,
            type: 'DELETE',
            success: function(response) {
               getDataUser();
               showAlert('Data user berhasil dihapus', 'success');
            },
            error: function() {
               showAlert('Gagal menghapus data user', 'danger');
            }
         });
      }
   }

   function deleteSelectedUsers(message) {
      var checkedBoxes = $('input[name="checkbox-table"]:checked');
      if (checkedBoxes.length === 0) {
         alert('Pilih minimal satu user untuk dihapus');
         return;
      }

      if (confirm(message)) {
         var ids = [];
         checkedBoxes.each(function() {
            ids.push($(this).val());
         });

         $.ajax({
            url: '<?= base_url('admin/user/bulk-delete') ?>',
            type: 'POST',
            data: {
               ids: ids
            },
            success: function(response) {
               getDataUser();
               showAlert('Data user terpilih berhasil dihapus', 'success');
            },
            error: function() {
               showAlert('Gagal menghapus data user', 'danger');
            }
         });
      }
   }

   function checkAll() {
      var isChecked = $('#checkAll').is(':checked');
      $('input[name="checkbox-table"]').prop('checked', isChecked);
   }

   function showAlert(message, type) {
      const alertHtml = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
         ${message}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>`;
      $('#list-data-user').prepend(alertHtml);
   }
</script>

<?= $this->endSection() ?>