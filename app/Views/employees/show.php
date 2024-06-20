<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Detail Data Karyawan
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Detail Data Karyawan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('employees') ?>" class="btn btn-sm btn-primary">
                            <span class="align-text-bottom"></span>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="row">
                    <div class="col-md-7">
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">
                                NIP
                            </label>
                            <div class="align-items-center">
                                <input class="form-control" value="<?= $employee[0]['nip'] ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">
                                Nama Lengkap
                            </label>
                            <div class="align-items-center">
                                <input class="form-control" value="<?= $employee[0]['nama_lengkap'] ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">
                                Email
                            </label>
                            <div class="align-items-center">
                                <input class="form-control" value=" <?= $employee[0]['email'] ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">
                                Username
                            </label>
                            <div class="align-items-center">
                                <input class="form-control" value="<?= $employee[0]['username'] ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">
                                Nomor Telepon
                            </label>
                            <div class="align-items-center">
                                <input class="form-control" value="<?= $employee[0]['no_telp'] ?>" readonly>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">
                                Jabatan
                            </label>
                            <div class="align-items-center">
                                <input class="form-control" value="<?= $employee[0]['nama_jabatan'] ?>" readonly>
                            </div>
                        </div>

                        <div class="align-items-center">
                            <a href="<?= base_url('employees/' . $employee[0]['id']) ?>/edit" class="btn btn-primary">
                                Edit
                            </a>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection(); ?>