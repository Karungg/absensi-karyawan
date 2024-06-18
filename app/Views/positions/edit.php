<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Data Jabatan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('positions') ?>" class="btn btn-sm btn-primary">
                            <span class="align-text-bottom me-1"></span>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="row">
                    <div class="col-md-7">
                        <?php $errors = validation_errors() ?>
                        <?= form_open('positions/' . $position[0]['id_jabatan'] . '/edit') ?>
                        <?= csrf_field() ?>
                        <?= form_hidden('_method', 'PUT') ?>
                        <?= form_hidden('id_jabatan', $position[0]['id_jabatan']) ?>
                        <div class="mb-3 position-relative">
                            <label for="nama_jabatan" class="form-label fw-bold">
                                Nama Jabatan
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="text" class="form-control <?= (isset($errors['nama_jabatan'])) ? 'is-invalid' : '' ?>" name="nama_jabatan" id="nama_jabatan" placeholder="Nama Jabatan" value="<?= $position[0]['nama_jabatan'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama_jabatan') ?>
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