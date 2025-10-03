<?= $this->extend('templates/admin_page_layout') ?>
<?= $this->section('content') ?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?= view('admin/_messages'); ?>
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title"><b>Statistik Nilai Siswa</b></h4>
                        <p class="card-category">Ringkasan data nilai siswa</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-success card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">grade</i>
                                        </div>
                                        <p class="card-category">Total Nilai</p>
                                        <h3 class="card-title"><?= $stats['total_nilai'] ?? 0 ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons text-success">check</i>
                                            Data tersimpan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-info card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">trending_up</i>
                                        </div>
                                        <p class="card-category">Rata-rata Nilai</p>
                                        <h3 class="card-title"><?= number_format($stats['rata_rata'] ?? 0, 2) ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons text-info">assessment</i>
                                            Keseluruhan
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-warning card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">star</i>
                                        </div>
                                        <p class="card-category">Nilai Tertinggi</p>
                                        <h3 class="card-title"><?= $stats['nilai_tertinggi'] ?? 0 ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons text-warning">star</i>
                                            Maksimal
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="card card-stats">
                                    <div class="card-header card-header-danger card-header-icon">
                                        <div class="card-icon">
                                            <i class="material-icons">trending_down</i>
                                        </div>
                                        <p class="card-category">Nilai Terendah</p>
                                        <h3 class="card-title"><?= $stats['nilai_terendah'] ?? 0 ?></h3>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats">
                                            <i class="material-icons text-danger">warning</i>
                                            Minimal
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header card-header-primary">
                                        <h4 class="card-title">Distribusi Nilai</h4>
                                        <p class="card-category">Berdasarkan rentang nilai</p>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="text-primary">
                                                    <tr>
                                                        <th>Rentang Nilai</th>
                                                        <th>Jumlah Siswa</th>
                                                        <th>Persentase</th>
                                                        <th>Grade</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>90 - 100</td>
                                                        <td><?= $stats['grade_a'] ?? 0 ?></td>
                                                        <td><?= $stats['total_nilai'] > 0 ? number_format(($stats['grade_a'] ?? 0) / $stats['total_nilai'] * 100, 1) : 0 ?>%</td>
                                                        <td><span class="badge badge-success">A</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>80 - 89</td>
                                                        <td><?= $stats['grade_b'] ?? 0 ?></td>
                                                        <td><?= $stats['total_nilai'] > 0 ? number_format(($stats['grade_b'] ?? 0) / $stats['total_nilai'] * 100, 1) : 0 ?>%</td>
                                                        <td><span class="badge badge-info">B</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>70 - 79</td>
                                                        <td><?= $stats['grade_c'] ?? 0 ?></td>
                                                        <td><?= $stats['total_nilai'] > 0 ? number_format(($stats['grade_c'] ?? 0) / $stats['total_nilai'] * 100, 1) : 0 ?>%</td>
                                                        <td><span class="badge badge-warning">C</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>< 70</td>
                                                        <td><?= $stats['grade_d'] ?? 0 ?></td>
                                                        <td><?= $stats['total_nilai'] > 0 ? number_format(($stats['grade_d'] ?? 0) / $stats['total_nilai'] * 100, 1) : 0 ?>%</td>
                                                        <td><span class="badge badge-danger">D</span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-3">
                            <div class="col-12">
                                <a href="<?= base_url('admin/nilai'); ?>" class="btn btn-primary">
                                    <i class="material-icons">arrow_back</i> Kembali ke Data Nilai
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>