<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Edit Data Karyawan
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Data Karyawan</h1>
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
                        <?php $errors = validation_errors() ?>
                        <?= form_open('employees/' . $employee[0]['id'] . '/edit') ?>
                        <?= csrf_field() ?>
                        <?= form_hidden('_method', 'PUT') ?>
                        <?= form_hidden('id', $employee[0]['id']) ?>
                        <div class="mb-3 position-relative">
                            <label for="nip" class="form-label fw-bold">
                                NIP
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="number" class="form-control <?= (isset($errors['nip'])) ? 'is-invalid' : '' ?>" name="nip" id="nip" placeholder="NIP" value="<?= $employee[0]['nip'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nip') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="nama_lengkap" class="form-label fw-bold">
                                Nama Lengkap
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="text" class="form-control <?= (isset($errors['nama_lengkap'])) ? 'is-invalid' : '' ?>" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?= $employee[0]['nama_lengkap'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama_lengkap') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label fw-bold">
                                Email
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="email" class="form-control <?= (isset($errors['email'])) ? 'is-invalid' : '' ?>" name="email" id="email" placeholder="Nama Lengkap" value="<?= $employee[0]['email'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('email') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="username" class="form-label fw-bold">
                                Username
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="username" class="form-control <?= (isset($errors['username'])) ? 'is-invalid' : '' ?>" name="username" id="username" placeholder="Username" value="<?= $employee[0]['username'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('username') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="no_telp" class="form-label fw-bold">
                                Nomor Telepon
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="number" class="form-control <?= (isset($errors['no_telp'])) ? 'is-invalid' : '' ?>" name="no_telp" id="no_telp" placeholder="Nama Lengkap" value="<?= $employee[0]['no_telp'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('no_telp') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label fw-bold">
                                Password
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <input type="password" class="form-control <?= (isset($errors['password'])) ? 'is-invalid' : '' ?>" name="password" id="password" placeholder="Password">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('password') ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="positions" class="form-label fw-bold">
                                Jabatan
                                <sup class="text-danger">*</sup>
                            </label>
                            <div class="align-items-center">
                                <select class="form-select" name="positions">
                                    <?php foreach ($positions as $position) : ?>
                                        <option value="<?= $position['id_jabatan'] ?>"><?= $position['nama_jabatan'] ?></option>
                                    <?php endforeach ?>
                                </select>
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