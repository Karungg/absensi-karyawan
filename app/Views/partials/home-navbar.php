<nav class="navbar navbar-expand-md bg-dark navbar-dark py-3">
    <div class="container">
        <a class="navbar-brand bg-transparent fw-bold" href="#">Absensi Karyawan</a>
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav align-items-md-center gap-md-4 py-2 py-md-0">
                <li class="nav-item px-4 py-1 px-md-0 py-md-0">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('') ?>">Beranda</a>
                </li>
                <?php if (in_groups('admin')) : ?>
                    <li class="nav-item px-4 py-1 px-md-0 py-md-0">
                        <a class="nav-link" aria-current="page" href="<?= base_url('dashboard') ?>">Dashboard</a>
                    </li>
                <?php endif ?>
                <li class="nav-item px-4 py-1 px-md-0 py-md-0">
                    <form action="<?= base_url('logout') ?>" onsubmit="return confirm('Apakah anda yakin ingin keluar?')" method="get">
                        <button class="btn fw-bold btn-danger w-100">Keluar</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>