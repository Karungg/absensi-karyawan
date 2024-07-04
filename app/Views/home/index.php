<?= $this->extend('layouts/home'); ?>

<?= $this->section('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-2">
                <div class="card-header">
                    Daftar Absensi Hari Ini
                </div>
                <div class="card-body">
                    <?php

                    use CodeIgniter\I18n\Time;

                    foreach ($attendances as $attendance) : ?>
                        <ul class="list-group">
                            <a href="#" class="list-group-item d-flex justify-content-between align-items-start py-3">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"><?= $attendance['nama_jadwal'] ?></div>
                                    <p class="mb-0"><?= $attendance['deskripsi'] ?></p>
                                </div>
                                <?= $this->include('partials/attendance-badges'); ?>
                            </a>
                        </ul>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    Informasi Karyawan
                </div>
                <div class="card-body">
                    <ul class="ps-3">
                        <li class="mb-1">
                            <span class="fw-bold d-block">Nama : </span>
                            <span><?= user()->nama_lengkap ?></span>
                        </li>
                        <li class="mb-1">
                            <span class="fw-bold d-block">Email : </span>
                            <a href="mailto:<?= user()->email ?>"><?= user()->email ?></a>
                        </li>
                        <li class="mb-1">
                            <span class="fw-bold d-block">No. Telp : </span>
                            <a href="tel:<?= user()->no_telp ?>"><?= user()->no_telp ?></a>
                        </li>
                        <li class="mb-1">
                            <span class="fw-bold d-block">Bergabung Pada : </span>
                            <?php $created_at = Time::parse(user()->created_at, 'Asia/Jakarta') ?>
                            <span><?= $created_at->humanize() ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>