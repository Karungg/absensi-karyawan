<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= str_contains(uri_string(), 'dashboard') ? '' : 'text-dark' ?>" href="<?= base_url('dashboard') ?>">
                    <span class="align-text-bottom"></span>
                    Dashboard
                </a>
                <a class="nav-link <?= str_contains(uri_string(), 'positions') ? '' : 'text-dark' ?>" href="<?= base_url('positions') ?>">
                    <span class="align-text-bottom"></span>
                    Jabatan
                </a>
                <a class="nav-link <?= str_contains(uri_string(), 'employees') ? '' : 'text-dark' ?>" href="<?= base_url('employees') ?>">
                    <span class="align-text-bottom"></span>
                    Karyawan
                </a>
                <a class="nav-link <?= str_contains(uri_string(), 'holidays') ? '' : 'text-dark' ?>" href="<?= base_url('holidays') ?>">
                    <span class="align-text-bottom"></span>
                    Hari Libur
                </a>
            </li>
        </ul>

        <form action="<?= base_url('logout') ?>" method="get" onsubmit="return confirm('Apakah anda yakin ingin keluar?')">
            <button class="w-full mt-4 d-block bg-transparent border-0 fw-bold text-danger px-3">Keluar</button>
        </form>
    </div>
</nav>