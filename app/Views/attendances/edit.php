<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Edit Data Absensi
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Edit Data Absensi</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('attendances') ?>" class="btn btn-sm btn-primary">
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
                        <?= form_open('attendances/' . $attendance[0]['id_jadwal_absen'] . '/edit') ?>
                        <?= csrf_field() ?>
                        <?= form_hidden('_method', 'PUT') ?>
                        <?= form_hidden('id_jadwal_absen', $attendance[0]['id_jadwal_absen']) ?>
                        <div class="w-100">
                            <div class="mb-3">
                                <label for="nama_jadwal" class="form-label fw-bold">
                                    Nama Absensi
                                    <sup class="text-danger">*</sup>
                                </label>
                                <input type="text" class="form-control <?= (isset($errors['nama_jadwal'])) ? 'is-invalid' : '' ?>" name="nama_jadwal" id="nama_jadwal" placeholder="Nama Absensi" value="<?= $attendance[0]['nama_jadwal'] ?>">
                                <div class="invalid-feedback">
                                    <?= validation_show_error('nama_jadwal') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label fw-bold">
                                    Keterangan
                                    <sup class="text-danger">*</sup>
                                </label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control <?= (isset($errors['deskripsi'])) ? 'is-invalid' : '' ?>"><?= $attendance[0]['deskripsi'] ?></textarea>
                                <div class="invalid-feedback">
                                    <?= validation_show_error('deskripsi') ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="jam_masuk" class="form-label fw-bold">
                                            Absen Masuk
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" class="form-control <?= (isset($errors['jam_masuk'])) ? 'is-invalid' : '' ?>" name="jam_masuk" id="jam_masuk" placeholder="07:00" value="<?= $attendance[0]['jam_masuk'] ?>" maxlength="5">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('jam_masuk') ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="batas_jam_masuk" class="form-label fw-bold">
                                            Batas Absen Masuk
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" class="form-control <?= (isset($errors['batas_jam_masuk'])) ? 'is-invalid' : '' ?>" name="batas_jam_masuk" id="batas_jam_masuk" placeholder="08:00" value="<?= $attendance[0]['batas_jam_masuk'] ?>" maxlength="5">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('batas_jam_masuk') ?>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">Masukan dengan format 24:00.</small>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="jam_pulang" class="form-label fw-bold">
                                            Absen Pulang
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" class="form-control <?= (isset($errors['jam_pulang'])) ? 'is-invalid' : '' ?>" name="jam_pulang" id="jam_pulang" placeholder="16:00" value="<?= $attendance[0]['jam_pulang'] ?>" maxlength="5">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('jam_pulang') ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="batas_jam_pulang" class="form-label fw-bold">
                                            Batas Absen Pulang
                                            <sup class="text-danger">*</sup>
                                        </label>
                                        <input type="text" class="form-control <?= (isset($errors['batas_jam_pulang'])) ? 'is-invalid' : '' ?>" name="batas_jam_pulang" id="batas_jam_pulang" placeholder="17:00" value="<?= $attendance[0]['batas_jam_pulang'] ?>" maxlength="5">
                                        <div class="invalid-feedback">
                                            <?= validation_show_error('batas_jam_pulang') ?>
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block mt-1">Masukan dengan format 24:00.</small>
                            </div>

                            <div class="mb-3">
                                <label for="id_jabatan" class="form-label fw-bold">
                                    Jabatan
                                    <sup class="text-danger">*</sup>
                                </label>
                                <div class="row ms-1">
                                    <?php foreach ($positions as $position) : ?>
                                        <div class="form-check form-check-inline col-sm-4">
                                            <input class="form-check-input" type="checkbox" name="id_jabatan" id="<?= $position['nama_jabatan'] ?>" value="<?= $position['id_jabatan'] ?>">
                                            <label class="form-check-label" for="<?= $position['nama_jabatan'] ?>"><?= $position['nama_jabatan'] ?></label>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                                <?php if (isset($errors['id_jabatan'])) : ?>
                                    <small class="text-danger d-block mt-1">Kolom jabatan karyawan harus diisi setidaknya 1.</small>
                                <?php endif ?>
                                <small class="text-muted d-block mt-1">Pilih jabatan karyawan yang akan menggunakan absensi ini.</small>
                            </div>

                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-5">
                            <button class="btn btn-primary">
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