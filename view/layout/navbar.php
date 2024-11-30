<nav class="bg-white mb-3 z-5 py-2">
    <div class="container d-flex">
        <button class="btn nav-toggle d-md-none d-block btn-transparent">
            <i class="fa fa-bars"></i>
        </button>
        <div class="ms-auto dropdown" style="cursor:pointer">
            <div class="dropdown-toggle d-flex align-items-center" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="me-2">
                    <?= auth()->user()->nama_lengkap ?>
                </span>
                <img src="<?= assets("assets/" . auth()->user()->foto_profile) ?>" style="width: 40px; height: 40px" class="profil-img-small bg-dark" alt="">
            </div>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li>
                    <div class="dropdown-item">
                        <img src="<?= assets("assets/" . auth()->user()->foto_profile) ?>" style="width: 40px; height: 40px" class="profil-img-small bg-dark" alt="">
                        <span class="ms-2"> <?= auth()->user()->nama_lengkap ?></span>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>

                <li><a class="dropdown-item" href="<?= url("/admin/profile") ?>">Profile</a></li>
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>