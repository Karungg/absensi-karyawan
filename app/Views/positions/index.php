<?= $this->extend('layouts/app'); ?>

<?= $this->section('content'); ?>

<?= $this->include('partials/navbar'); ?>

<div class="container-fluid">
    <div class="row">
        <?= $this->include('partials/sidebar'); ?>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Jabatan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div>
                        <a href="<?= base_url('positions/create') ?>" class="btn btn-sm btn-primary">
                            <span class="align-text-bottom me-1"></span>
                            Tambah Data Jabatan
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <?php if (!empty(session()->getFlashdata('success'))) : ?>
                    <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                            <button class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    </div>
                <?php endif ?>
                <div class="table-responsive">
                    <table id="table-1" class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Jabatan</th>
                                <th class="text-center">Created At</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($positions as $position) :
                            ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= $position['nama_jabatan'] ?></td>
                                    <td class="text-center"><?= $position['created_at'] ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('positions/' . $position['id_jabatan']) ?>/edit" class="btn btn-success">Ubah</a>
                                        <form action="<?= base_url('positions/delete/' . $position['id_jabatan']) ?>" method="post" onsubmit="return confirm('Hapus' + ' <?= $position['nama_jabatan'] ?>?');" style="display: inline;">
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