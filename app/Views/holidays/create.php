<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Tambah Data Hari Libur
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Tambah Data Hari Libur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('holidays') ?>" class="btn btn-sm btn-primary">
                            <span class="align-text-bottom"></span>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="row">
                    <div class="col-md-7">
                        <?php $errors = validation_errors() ?>
                        <?= form_open('holidays/create') ?>
                        <?= csrf_field() ?>
                        <div class="mb-3 position-relative">
                            <label for="nama_hari_libur" class="form-label fw-bold">
                                Nama Hari Libur
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="text" class="form-control <?= (isset($errors['nama_hari_libur'])) ? 'is-invalid' : '' ?>" name="nama_hari_libur" id="nama_hari_libur" placeholder="Nama Hari Libur" value="<?= old('nama_hari_libur') ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama_hari_libur') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="keterangan" class="form-label fw-bold">
                                Keterangan
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="text" class="form-control <?= (isset($errors['keterangan'])) ? 'is-invalid' : '' ?>" name="keterangan" id="keterangan" placeholder="Keterangan" value="<?= old('keterangan') ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('keterangan') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="tgl_hari_libur" class="form-label fw-bold">
                                Tanggal Hari Libur
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="date" class="form-control <?= (isset($errors['tgl_hari_libur'])) ? 'is-invalid' : '' ?>" name="tgl_hari_libur" id="tgl_hari_libur" placeholder="Nama Hari Libur" value="<?= old('tgl_hari_libur') ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('tgl_hari_libur') ?>
                                </div>
                            </div>
                        </div>

                        <div class="align-items-center">
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?= $this->endSection(); ?>