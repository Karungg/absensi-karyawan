<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?= str_contains(uri_string(), 'dashboard') ? 'active' : '' ?>" aria-current="page" href="<?= base_url('dashboard') ?>">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Dashboard
                </a>
                <a class="nav-link <?= str_contains(uri_string(), 'positions') ? 'active' : '' ?>" aria-current="page" href="<?= base_url('positions') ?>">
                    <span data-feather="home" class="align-text-bottom"></span>
                    Jabatan
                </a>
            </li>
        </ul>

        <form action="<?= base_url('logout') ?>" method="get" onsubmit="return confirm('Apakah anda yakin ingin keluar?')">
            <button class="w-full mt-4 d-block bg-transparent border-0 fw-bold text-danger px-3">Keluar</button>
        </form>
    </div>
</nav>