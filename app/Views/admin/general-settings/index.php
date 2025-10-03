<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?= view('admin/_messages'); ?>
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"><b>Pengaturan</b></h4>
                    </div>
                    <div class="card-body mx-5 my-3">

                        <form action="<?= base_url('admin/general-settings/update'); ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="form-group mt-4">
                                <label for="school_name">Nama Sekolah</label>
                                <input type="text" id="school_name" class="form-control <?= invalidFeedback('school_name') ? 'is-invalid' : ''; ?>" name="school_name" placeholder="SMK 1 Indonesia" value="<?= $generalSettings->school_name; ?>" required>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('school_name'); ?>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="school_year">Tahun Ajaran</label>
                                <input type="text" id="school_year" class="form-control <?= invalidFeedback('school_year') ? 'is-invalid' : ''; ?>" name="school_year" placeholder="2024/2025" value="<?= $generalSettings->school_year; ?>" required>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('school_year'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <label for="copyright">Copyright</label>
                                        <input type="text" id="copyright" class="form-control <?= invalidFeedback('copyright') ? 'is-invalid' : ''; ?>" name="copyright" placeholder="@ 2024 All" value="<?= $generalSettings->copyright; ?>" required>
                                        <div class="invalid-feedback">
                                            <?= invalidFeedback('copyright'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="logo">Logo</label>
                                        <div style="margin-bottom: 10px; border: 1px solid #eee; padding: 10px; width: auto;">
                                            <img id="logo" src="<?= getLogo(); ?>" alt="logo" style="max-width: 250px; max-height: 250px;">
                                        </div>
                                        <div class="display-block">
                                            <button type="button" onclick="$('#logo-upload').trigger('click');" class="btn btn-primary btn-sm btn-file-upload">
                                                Ganti
                                            </button>
                                            <input type="file" id="logo-upload" name="logo" size="40" accept="image/jpg,image/jpeg,image/png,image/gif,image/svg+xml" onchange="$('#upload-file-info1').html($(this).val().replace(/.*[\/\\]/, ''));">
                                            <span class="text-sm text-secondary">(.png, .jpg, .jpeg, .gif, .svg)</span>
                                        </div>
                                        <span class='label label-info' id="upload-file-info1"></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </form>

                        <hr>
                    </div>
                </div>

                <!-- WhatsApp Settings Panel -->
                <div class="card mt-4">
                    <div class="card-header card-header-info">
                        <h4 class="card-title"><b>Pengaturan WhatsApp</b></h4>
                        <p class="card-category">Konfigurasi API WhatsApp dan template pesan</p>
                    </div>
                    <div class="card-body mx-5 my-3">
                        <form action="<?= base_url('admin/general-settings/update-whatsapp'); ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <div class="form-group mt-4">
                                <label for="waha_api_url">URL/Link WAHA API</label>
                                <input type="url" id="waha_api_url" class="form-control <?= invalidFeedback('waha_api_url') ? 'is-invalid' : ''; ?>" name="waha_api_url" placeholder="http://localhost:3000" value="<?= $generalSettings->waha_api_url ?? 'http://localhost:3000'; ?>">
                                <small class="form-text text-muted">URL endpoint untuk WAHA (WhatsApp HTTP API)</small>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('waha_api_url'); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <label for="waha_api_key">API Key</label>
                                        <input type="text" id="waha_api_key" class="form-control <?= invalidFeedback('waha_api_key') ? 'is-invalid' : ''; ?>" name="waha_api_key" placeholder="API Key (opsional)" value="<?= $generalSettings->waha_api_key ?? ''; ?>">
                                        <small class="form-text text-muted">API Key jika diperlukan oleh provider</small>
                                        <div class="invalid-feedback">
                                            <?= invalidFeedback('waha_api_key'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mt-4">
                                        <label for="waha_x_api_key">X-API-Key</label>
                                        <input type="text" id="waha_x_api_key" class="form-control <?= invalidFeedback('waha_x_api_key') ? 'is-invalid' : ''; ?>" name="waha_x_api_key" placeholder="X-API-Key header" value="<?= $generalSettings->waha_x_api_key ?? ''; ?>">
                                        <small class="form-text text-muted">Header X-API-Key untuk autentikasi</small>
                                        <div class="invalid-feedback">
                                            <?= invalidFeedback('waha_x_api_key'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="wa_template_masuk">Template Pesan Absen Masuk</label>
                                <textarea id="wa_template_masuk" class="form-control <?= invalidFeedback('wa_template_masuk') ? 'is-invalid' : ''; ?>" name="wa_template_masuk" rows="3" placeholder="Template pesan untuk absen masuk"><?= $generalSettings->wa_template_masuk ?? 'Halo {nama_siswa}, anak Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.'; ?></textarea>
                                <small class="form-text text-muted">
                                    Variabel yang tersedia: {nama_siswa}, {tanggal}, {jam_masuk}
                                </small>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('wa_template_masuk'); ?>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="wa_template_pulang">Template Pesan Absen Pulang Siswa</label>
                                <textarea id="wa_template_pulang" class="form-control <?= invalidFeedback('wa_template_pulang') ? 'is-invalid' : ''; ?>" name="wa_template_pulang" rows="3" placeholder="Template pesan untuk absen pulang"><?= $generalSettings->wa_template_pulang ?? 'Halo {nama_siswa}, anak Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.'; ?></textarea>
                                <small class="form-text text-muted">
                                    Variabel yang tersedia: {nama_siswa}, {tanggal}, {jam_pulang}
                                </small>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('wa_template_pulang'); ?>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="wa_template_guru_masuk">Template Pesan Absen Masuk Guru</label>
                                <textarea id="wa_template_guru_masuk" class="form-control <?= invalidFeedback('wa_template_guru_masuk') ? 'is-invalid' : ''; ?>" name="wa_template_guru_masuk" rows="3" placeholder="Template pesan untuk absen masuk guru"><?= $generalSettings->wa_template_guru_masuk ?? 'Halo {nama_guru}, Anda telah absen masuk pada {tanggal} pukul {jam_masuk}. Terima kasih.'; ?></textarea>
                                <small class="form-text text-muted">
                                    Variabel yang tersedia: {nama_guru}, {tanggal}, {jam_masuk}
                                </small>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('wa_template_guru_masuk'); ?>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <label for="wa_template_guru_pulang">Template Pesan Absen Pulang Guru</label>
                                <textarea id="wa_template_guru_pulang" class="form-control <?= invalidFeedback('wa_template_guru_pulang') ? 'is-invalid' : ''; ?>" name="wa_template_guru_pulang" rows="3" placeholder="Template pesan untuk absen pulang guru"><?= $generalSettings->wa_template_guru_pulang ?? 'Halo {nama_guru}, Anda telah absen pulang pada {tanggal} pukul {jam_pulang}. Terima kasih.'; ?></textarea>
                                <small class="form-text text-muted">
                                    Variabel yang tersedia: {nama_guru}, {tanggal}, {jam_pulang}
                                </small>
                                <div class="invalid-feedback">
                                    <?= invalidFeedback('wa_template_guru_pulang'); ?>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-info btn-block">Simpan Pengaturan WhatsApp</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>