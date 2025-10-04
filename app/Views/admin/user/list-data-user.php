<?php if (!$empty): ?>
   <div class="card-body">
      <div class="table-responsive">
         <table class="table">
            <thead class="text-primary">
               <tr>
                  <?php if ($userRole === 'superadmin'): ?>
                     <th width="20"><input type="checkbox" class="checkbox-table" id="checkAll"></th>
                  <?php endif; ?>
                  <th>No</th>
                  <th>Nama Lengkap</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>NUPTK</th>
                  <th>No HP</th>
                  <th>Status</th>
                  <th width="1%"><b>Aksi</b></th>
               </tr>
            </thead>
            <tbody>
               <?php $no = 1; ?>
               <?php foreach ($data as $user): ?>
               <tr>
                  <?php if ($userRole === 'superadmin'): ?>
                     <td><input type="checkbox" name="checkbox-table" class="checkbox-table" value="<?= $user->id ?>"></td>
                  <?php endif; ?>
                  <td><?= $no++ ?></td>
                  <td><?= esc($user->nama_lengkap) ?></td>
                  <td><?= esc($user->username) ?></td>
                  <td><?= esc($user->email) ?></td>
                  <td>
                     <span class="badge badge-<?= $user->role === 'superadmin' ? 'danger' : 'primary' ?>">
                        <?= ucfirst($user->role) ?>
                     </span>
                  </td>
                  <td><?= esc($user->nuptk ?? '-') ?></td>
                  <td><?= esc($user->no_hp ?? '-') ?></td>
                  <td>
                     <?php if ($user->active == 1): ?>
                        <span class="badge badge-success">Aktif</span>
                     <?php else: ?>
                        <span class="badge badge-secondary">Tidak Aktif</span>
                     <?php endif; ?>
                  </td>
                  <td>
                     <div class="d-flex justify-content-center">
                        <?php if ($userRole === 'superadmin'): ?>
                           <a title="Edit" href="<?= base_url('admin/user/edit/' . $user->id) ?>" class="btn btn-primary p-2" id="<?= $user->id ?>">
                              <i class="material-icons">edit</i>
                           </a>
                           <form action="<?= base_url('admin/user/delete/' . $user->id) ?>" method="post" class="d-inline">
                              <?= csrf_field(); ?>
                              <input type="hidden" name="_method" value="DELETE">
                              <button title="Delete" onclick="return confirm('Konfirmasi untuk menghapus data');" type="submit" class="btn btn-danger p-2" id="<?= $user->id ?>">
                                 <i class="material-icons">delete_forever</i>
                              </button>
                           </form>
                        <?php endif; ?>
                        <?php if ($user->role === 'guru'): ?>
                        <a title="Download QR Code" href="<?= base_url('admin/qr/guru/' . $user->id . '/download') ?>" class="btn btn-success p-2">
                           <i class="material-icons">qr_code</i>
                        </a>
                        <?php endif; ?>
                        <?php if ($userRole === 'guru' && empty($user->role === 'guru')): ?>
                           <span class="text-muted small">Hanya dapat melihat data</span>
                        <?php endif; ?>
                     </div>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
         </table>
      </div>
   </div>
<?php else: ?>
   <div class="card-body">
      <div class="alert alert-info">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="material-icons">close</i>
         </button>
         <span>
            <b>Info - </b> Tidak ada data user yang ditemukan.
         </span>
      </div>
   </div>
<?php endif; ?>