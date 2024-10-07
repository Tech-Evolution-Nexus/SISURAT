<aside class="d-flex  flex-column bg-primary sidebar z-5">
    <div class="p-4 d-flex align-items-center ">
        <img src="<?= assets("assets/logo-admin.png") ?>" alt="">
        <button class="btn nav-toggle d-md-none ms-auto text-white d-flex align-items-center btn-transparent"><i class="fa fa-close"></i></button>
    </div>

    <ul class="list-unstyled d-flex flex-column gap-2 p-4">
        <li>
            <a class="text-white sidebar-item side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/dashboard">
                <i class="fa fa-bars"></i>
                <span class="d-inline-block ms-3">Dashboard</span>
            </a>
        </li>

        <!-- Master Data -->
        <li>
            <a class="text-white sidebar-item  d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="#">
                <i class="fa fa-database"></i>
                <span class="d-inline-block ms-3">Master Data</span>
            </a>
            <ul class="list-unstyled ps-4">
                <li>
                    <a class="text-white sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/rekam-medis">
                        <i class="fa fa-user-doctor"></i>
                        <span class="d-inline-block ms-3">Rekam Medis</span>
                    </a>
                </li>
                <li>
                    <a class="text-white sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/pasien">
                        <i class="fa fa-hospital-user"></i>
                        <span class="d-inline-block ms-3">Pasien</span>
                    </a>
                </li>
                <li>
                    <a class="text-white sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/obat">
                        <i class="fa fa-capsules"></i>
                        <span class="d-inline-block ms-3">Obat</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Setting -->
        <li>
            <a class="text-white sidebar-item fs-6 d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="#">
                <i class="fa fa-cog"></i>
                <span class="d-inline-block ms-3">Pengaturan</span>
            </a>
            <ul class="list-unstyled ps-4">
                <li>
                    <a class="text-white sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/jadwal">
                        <i class="fa fa-calendar-alt"></i>
                        <span class="d-inline-block ms-3">Jadwal Praktik</span>
                    </a>
                </li>
                <li>
                    <a class="text-white sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/laporan">
                        <i class="fa fa-file-alt"></i>
                        <span class="d-inline-block ms-3">Laporan</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
