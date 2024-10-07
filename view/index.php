<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= assets("style.css") ?>">

</head>

<body>
    <nav class="navbar position-sticky z-3 top-0 left-0 w-100 navbar-expand-lg bg-white">
        <div class="container">
            <a class="navbar-brand" href="#">SIKAMDIS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SIKAMDIS APP</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tentang kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class=" h-100 hero bg-white">
        <div class="container row align-items-center mx-auto flex-wrap-reverse">
            <div class="col-md-6 col-12 position-relative">
                <h1 class="fw-bold text-body-secondary big-brand">SIKAMDIS</h1>
                <h1 class="fw-bold text-primary title-brand">SIKAMDIS</h1>
                <p class="text-body-secondary">SIKAMDIS adalah aplikasi untuk mengelola rekam medis pasien secara digital,
                    memudahkan pencatatan,
                    penyimpanan, dan
                    akses informasi kesehatan guna meningkatkan efisiensi layanan medis.</p>
                <div class="text-body-secondary d-flex gap-2 align-items-center"><span class="line bg-secondary"></span>
                    <span>Jl. Abdul
                        Wahid
                        No.
                        20, Jember</span>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <img src="<?= assets("assets/heroImage.png") ?>" class="w-100" alt="">
            </div>
        </div>
    </section>

    <section class="check-history bg-primary   text-white">
        <div class="container">
            <h2>Telusuri Riwayat Kunjungan Pasien</h2>
            <p>Masukkan nama dan nomo r telepon untuk mendapatkan link akses melalui SMS. Klik ‘Kirim’ dan cek pesan SMS
                Anda
                untuk
                melihat informasi kunjungan.</p>

            <form action="" class="row align-items-end g-3" method="post">
                <div class=" col-md-5 col-12">
                    <div class="form-group p-0">
                        <label for="name" class="mb-1 ">Nama</label>
                        <input type="text" name="name" class="form-control bg-transparent " placeholder="Nama" id="">
                    </div>
                </div>
                <div class=" col-md-5 col-12">
                    <div class="form-group p-0">
                        <label for="phone" class="mb-1">Nomor telepon</label>
                        <input type="text" name="phone" class="form-control bg-transparent " placeholder="Nomor telepon" id="">
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <button class="btn btn-warning px-5">Kirim</button>
                </div>
            </form>
        </div>
    </section>


    <section class="about-app">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Tentang <span class="text-primary">SIKAMDIS</span></h2>
            <div class="row gy-5 align-items-center">
                <div class="col-md-6 col-12 ">
                    <!-- <div class="layer-img rounded-2"> -->
                    <img src="<?= assets("assets/doctor.png") ?>" class="w-100" alt="">
                    <!-- </div> -->
                </div>
                <div class="col-md-6 col-12">
                    <h6 class="fw-bold mb-0 text-body-secondary ">TENTANG</h6>
                    <h3 class="text-primary fw-bold">SIKAMDIS</h3>
                    <p class="text-body-secondary">SIKAMDIS aplikasi adalah sistem berbasis digital yang digunakan untuk
                        mencatat, menyimpan, dan
                        mengelola informasi medis
                        pasien secara elektronik. Aplikasi ini menggantikan rekam medis tradisional berbasis kertas dan
                        memberikan banyak
                        keuntungan baik bagi pasien maupun tenaga medis</p>
                </div>
            </div>
        </div>
    </section>
    <section class="feature-app">
        <div class="container">
            <div class="row gy-5 flex-wrap-reverse align-items-center">
                <div class="col-md-6 col-12">
                    <h6 class="fw-bold mb-0 text-body-secondary ">FITUR</h6>
                    <h3 class=" fw-bold">FITUR UNGGULAN <span class="text-primary">
                            SIKAMDIS
                        </span></h3>
                    <p class="text-body-secondary">SIKAMDIS memiliki beberapa fitur unggulan antara lain:</p>
                    <ul class="list-unstyled d-flex flex-column gap-3">
                        <li class="d-flex gap-3 text-body-secondary"><i class="fa-solid text-primary fa-hospital-user"></i>
                            <span>Akses
                                Data Pasien yang
                                Mudah dan
                                Cepat</span>
                        </li>
                        <li class="d-flex gap-3 text-body-secondary"><i class="fa-solid text-primary fa-list"></i>
                            <span>Manajemen Riwayat
                                Kesehatan
                                Pasien</span>
                        </li>
                        <li class="d-flex gap-3 text-body-secondary"><i class="fa-solid text-primary fa-lock"></i>
                            <span>Keamanan dan
                                Privasi Data</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6 col-12 ">
                    <!-- <div class="layer-img rounded-2"> -->
                    <img src="<?= assets("assets/doctor.png") ?>" class="w-100" alt="">
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>
    <section class="why-choose-app">
        <div class="container">
            <h2 class="text-center fw-bold mb-5">Kenapa memilih <span class="text-primary">SIKAMDIS</span></h2>
            <div class="row gy-5 align-items-center">

                <div class="col-md-3 col-sm-4 col-12">
                    <div class="card border-0 ">
                        <div class="card-body p-5 text-center">
                            <i class="fa-solid fa-stopwatch display-6 text-warning mb-2 d-inline-block"></i>
                            <p class="text-body-secondary text-center">Akses Informasi yang Cepat dan Akurat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12">
                    <div class="card border-0 ">
                        <div class="card-body p-5 text-center">
                            <i class="fa-solid fa-user-gear display-6 text-warning mb-2 d-inline-block"></i>
                            <p class="text-body-secondary text-center">Pengelolaan Riwayat Kesehatan yang Terpusat</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12">
                    <div class="card border-0 ">
                        <div class="card-body p-5 text-center">
                            <i class="fa-solid fa-lock display-6 text-warning mb-2 d-inline-block"></i>
                            <p class="text-body-secondary text-center">Meningkatkan Keamanan dan Privasi Data</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-12">
                    <div class="card border-0 ">
                        <div class="card-body p-5 text-center">
                            <i class="fa-solid fa-triangle-exclamation display-6 text-warning mb-2 d-inline-block"></i>
                            <p class="text-body-secondary text-center">Mengurangi Kesalahan Medis</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>