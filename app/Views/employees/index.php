<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Karyawan
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Karyawan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('employees/create') ?>" class="btn btn-sm btn-primary">
                            <span class="align-text-bottom"></span>
                            Tambah Data Karyawan
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                <div class="mb-2">
                    <a href="<?= base_url('employees/export-pdf') ?>" class="btn btn-danger">Export Pdf</a>
                    <a href="<?= base_url('employees/export-excel') ?>" class="btn btn-success">Export Excel</a>
                </div>
                <div class="table-responsive">
                    <table id="table-1" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">NIP</th>
                                <th class="text-center">Nama Lengkap</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Nomor Telepon</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($employees as $employee) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= $employee['nip'] ?></td>
                                    <td class="text-center"><?= $employee['nama_lengkap'] ?></td>
                                    <td class="text-center"><?= $employee['email'] ?></td>
                                    <td class="text-center"><?= $employee['no_telp'] ?></td>
                                    <td class="text-center"><?= $employee['nama_jabatan'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('employees/' . $employee['id']) ?>" class="btn btn-primary">Detail</a>
                                        <a href="<?= base_url('employees/' . $employee['id']) ?>/edit" class="btn btn-success">Ubah</a>
                                        <form action="<?= base_url('employees/delete/' . $employee['id']) ?>" method="post" onsubmit="return confirm('Hapus' + ' <?= $employee['nama_lengkap'] ?>?');" style="display: inline;">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger">Hapus</a>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<script>
    new DataTable("#dataTable");
</script>
<?= $this->endSection(); ?>