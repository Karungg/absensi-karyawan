<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Data Kehadiran
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Data Kehadiran</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                </div>
            </div>

            <div class="py-4">
                <div class="row">
                    <?php

                    use CodeIgniter\I18n\Time;

                    foreach ($attendances as $attendance) : ?>
                        <div class="col-md-7">
                            <ul class="list-group">
                                <a href="" class="list-group-item d-flex justify-content-between align-items-start py-3">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><?= $attendance['nama_jadwal'] ?></div>
                                        <p class="mb-0"><?= $attendance['deskripsi'] ?></p>
                                    </div>
                                    <?php
                                    $now = Time::now()->toTimeString();
                                    $start_time = Time::parse($attendance['jam_masuk'])->toTimeString();
                                    $limit_start_time = Time::parse($attendance['batas_jam_masuk'])->toTimeString();
                                    $end_time = Time::parse($attendance['jam_pulang'])->toTimeString();
                                    $limit_end_time = Time::parse($attendance['batas_jam_pulang'])->toTimeString();
                                    ?>
                                    <?php
                                    if (!empty($holiday)) { ?>
                                        <span class="badge text-bg-success rounded-pill">Hari Libur</span>
                                    <?php } else { ?>

                                        <?php if ($start_time <= $now && $limit_start_time >= $now) { ?>
                                            <span class="badge bg-primary rounded-pill">Jam Masuk</span>
                                        <?php } elseif ($end_time <= $now && $limit_end_time >= $now) {  ?>
                                            <span class="badge text-bg-warning rounded-pill">Jam Pulang</span>
                                        <?php } else { ?>
                                            <span class="badge text-bg-danger rounded-pill">Tutup</span>
                                        <?php } ?>

                                    <?php } ?>
                                </a>
                            </ul>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    new DataTable("#dataTable");
</script>
<?= $this->endSection(); ?>