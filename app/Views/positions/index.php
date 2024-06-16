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
                        <a href="#" class="btn btn-sm btn-primary">
                            <span data-feather="plus-circle" class="align-text-bottom me-1"></span>
                            Tambah Data Jabatan
                        </a>
                    </div>
                </div>
            </div>

            <div class="py-4">
                <div class="table-responsive">
                    <table id="table-1" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011-04-25</td>
                                <td>$320,800</td>
                            </tr>
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