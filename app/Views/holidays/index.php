<?= $this->extend('layouts/app'); ?>

<?= $this->section('title') ?>
Hari Libur
<?= $this->endSection() ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Hari Libur</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('holidays/create') ?>" class="btn btn-sm btn-primary">
                            <span class="align-text-bottom"></span>
                            Tambah Data Hari Libur
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
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif ?>
                <div class="mb-2">
                    <a href="<?= base_url('holidays/export-pdf') ?>" class="btn btn-danger">Export Pdf</a>
                    <a href="<?= base_url('holidays/export-excel') ?>" class="btn btn-success">Export Excel</a>
                </div>
                <div class="table-responsive">
                    <table id="table-1" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Hari Libur</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($holidays as $holiday) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= $holiday['nama_hari_libur'] ?></td>
                                    <td class="text-center"><?= $holiday['keterangan'] ?></td>
                                    <td class="text-center"><?= $holiday['created_at'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('holidays/' . $holiday['id_hari_libur']) ?>/edit" class="btn btn-success">Ubah</a>
                                        <form action="<?= base_url('holidays/delete/' . $holiday['id_hari_libur']) ?>" method="post" onsubmit="return confirm('Hapus' + ' <?= $holiday['nama_hari_libur'] ?>?');" style="display: inline;">
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