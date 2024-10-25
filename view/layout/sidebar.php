<aside class="d-flex  flex-column bg-white shadow-sm sidebar  custom-scroll z-5">
    <div class="p-4 d-flex align-items-center ">
        <img src="<?= assets("assets/logo-admin.png") ?>" alt="">
        <button class="btn nav-toggle d-md-none ms-auto text-body-secondary d-flex align-items-center btn-transparent"><i class="fa fa-close"></i></button>
    </div>

    <ul class="list-unstyled d-flex flex-column gap-2 py-4 px-2">
        <!-- Master Data -->
        <li>
            <a class="text-body-secondary sidebar-item  d-flex align-items-center  rounded py-2 text-decoration-none" href="#">
                <span class="d-inline-block  text-uppercase fw-bold">Dashboard</span>
            </a>
            <ul class="list-unstyled ps-2">
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/rekam-medis">
                        <i class="fa fa-table-columns"></i>
                        <span class="d-inline-block ms-3">Dashboard</span>
                    </a>
                </li>
            </ul>
        </li>
        <hr class="my-1">
        <li>
            <a class="text-body-secondary sidebar-item  d-flex align-items-center  rounded py-2 text-decoration-none" href="#">
                <span class="d-inline-block text-uppercase fw-bold">Pengajuan</span>
            </a>
            <ul class="list-unstyled ps-2">
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/surat-masuk">
                        <i class="fa fa-envelope"></i>
                        <span class="d-inline-block ms-3">Surat Masuk</span>
                    </a>
                </li>
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/surat-selesai">
                        <i class="fa fa-envelope"></i>
                        <span class="d-inline-block ms-3">Surat Selesai</span>
                    </a>
                </li>
            </ul>
        </li>
        <hr class="my-1">
        <li>
            <a class="text-body-secondary sidebar-item  d-flex align-items-center  rounded py-2 text-decoration-none" href="#">
                <span class="d-inline-block text-uppercase fw-bold">Master Data</span>
            </a>
            <ul class="list-unstyled ps-2">
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/users">
                        <i class="fa fa-users"></i>
                        <span class="d-inline-block ms-3">Users</span>
                    </a>
                </li>
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/surat">
                        <i class="fa fa-envelopes-bulk"></i>
                        <span class="d-inline-block ms-3">Surat</span>
                    </a>
                </li>
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/kartu-keluarga">
                        <i class="fa fa-list"></i>
                        <span class="d-inline-block ms-3">Kartu Keluarga</span>
                    </a>
                </li>
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/master-rw">
                        <i class="fa fa-users"></i>
                        <span class="d-inline-block ms-3">RT & RW</span>
                    </a>
                </li>
            </ul>
        </li>
        <hr class="my-1">

        <li>
            <a class="text-body-secondary sidebar-item  d-flex align-items-center  rounded py-2 text-decoration-none" href="#">
                <span class="d-inline-block text-uppercase fw-bold">PENGATURAN</span>
            </a>
            <ul class="list-unstyled ps-2">
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/pengaturan">
                        <i class="fa fa-users"></i>
                        <span class="d-inline-block ms-3">Berita</span>
                    </a>
                </li>
                <li>
                    <a class="text-body-secondary sidebar-subitem side-link d-flex align-items-center px-3 rounded py-2 text-decoration-none" href="/admin/tentang">
                        <i class="fa fa-envelopes-bulk"></i>
                        <span class="d-inline-block ms-3">Tentang</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>