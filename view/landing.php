<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISURAT BADEAN</title>
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link href="<?= assets("css/fontawesome.css") ?>" rel="stylesheet">
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <style>
        .navbar {
            z-index: 999;
        }

        section {
            padding-block: 2rem;
        }

        img.logo {
            filter: brightness(0) invert(1);
        }

        body,
        section {
            overflow-x: hidden;
        }
    </style>
</head>

<body>


    <nav class="navbar navbar-expand-lg bg-primary position-sticky top-0 left-0 w-100">
        <div class="container">
            <a class="navbar-brand" href="/"><img class="logo" src="<?= assets("assets/logo-badean.png") ?>" style="width: 150px;" alt=""></a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-md-4">
                    <li class="nav-item">
                        <a class="nav-link text-white " aria-current="page" href="<?= url("/") ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="<?= url("/berita") ?>">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Tentang Kami</a>
                    </li>
                </ul>
                <div class="d-flex" role="search">
                    <?php if (auth()->check()): ?>
                        <a href="<?= url("/admin") ?>" class="btn btn-light px-4"><i class="fa fa-home"></i> Dashboard</a>

                    <?php else: ?>
                        <a href="<?= url("/login") ?>" class="btn btn-light px-4">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    <section id="hero" class="mb-4 text-white " style="background-size:cover;background-image: url(<?= assets("assets/heroBg.svg") ?>);">
        <div class="container ">
            <div class="row  align-items-md-center align-items-center" style="height: 70vh;">
                <div class="col-md-6 col-12">
                    <h6 class="item-bottom"><?= $data->data->nama_website ?></h6>
                    <h1 class="item-bottom"><?= $data->data->judul_home ?></h1>
                    <p class="item-bottom"><?= $data->data->deskripsi_home ?></p>
                    <!-- <button class="btn btn-primary px-5 mb-4 me-2">
                        <i class="fa fa-download"></i>
                    Login
                    </button> -->
                    <a href="<?=url("/downloadapk")?>" class=" item-bottom btn btn-warning mb-4"><i class="fa fa-envelope"></i> Pengajuan Surat</a>
                </div>
                <div class="col-md-6 col-12">
                    <center>
                        <img class="item-right" style=" max-width: 80%;" src="<?= assets("assets/" . $data->data->image_hero) ?>" alt="Responsive mockup">
                    </center>
                </div>

            </div>
        </div>
    </section>

    <section style="min-height: 70vh;" class="d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <h2 class="text-primary text-center item-top">TENTANG BADEAN</h2>
            <div class="row justify-content-center align-items-center g-4">

                <div class=" col-md-6 col-12">
                    <center>
                        <img class="item-left" style=" max-width: 50%;" src="<?= assets("assets/mocupweb.jpg") ?>" alt="Responsive mockup">
                    </center>
                </div>
                <div class=" col-md-6 col-12 item-right">
                    <h3 class="text-center text-md-start"><?= $data->data->nama_website ?></h3>
                    <p class="text-center text-md-start"><?= $data->data->tentang_aplikasi ?></p>
                </div>
            </div>
        </div>
    </section>
    <section style="min-height: 70vh;" class="d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <h2 class="text-primary text-center item-top">TENTANG APLIKASI</h2>
            <div class="row justify-content-center align-items-center g-4">
                <div class=" col-md-6 col-12 item-left">
                    <h3 class="text-center text-md-start"><?= $data->data->nama_website ?></h3>
                    <p class="text-center text-md-start"><?= $data->data->tentang_aplikasi ?></p>
                </div>
                <div class=" col-md-6 col-12">
                    <center>
                        <img class="item-right" style=" max-width: 50%;" src="<?= assets("assets/mocupweb.jpg") ?>" alt="Responsive mockup">
                    </center>
                </div>
            </div>
        </div>
    </section>
    <section style="min-height: 70vh;" class="d-flex justify-content-center align-items-center flex-column">
        <div class="container">
            <h2 class="text-primary text-center mb-5 item-top">FITUR UNGGULAN APLIKASI</h2>
            <div class="row justify-content-center g-4">
                <div class="col-lg-4 col-md-6 col-12 item-bottom">
                    <div class="text-center ">
                        <i class="fs-1  mb-3 text-primary fa fa-envelope"></i>
                    </div>
                    <h6 class="fw-bold text-center ">Kelola Surat dengan Mudah</h6>
                    <p class="text-center ">Semua kebutuhan surat-menyurat Anda tersedia dalam satu platform yang praktis dan efisien.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-12 item-bottom">
                    <div class="text-center ">
                        <i class="fs-1  mb-3 text-primary fa-solid fa-clipboard"></i>
                    </div>
                    <h6 class="fw-bold text-center ">Template Surat Profesional</h6>
                    <p class="text-center ">Siapkan surat dengan template profesional, mempermudah pengajuan dan memaksimalkan hasil yang Anda inginkan.</p>
                </div>
                <div class="col-lg-4 col-md-6 col-12 item-bottom">
                    <div class="text-center ">
                        <i class="fs-1  mb-3 text-primary fa-solid fa-eye"></i>
                    </div>
                    <h6 class="fw-bold text-center ">Pantau Surat dengan Mudah</h6>
                    <p class="text-center ">Melalui fitur pelacakan real-time, Anda dapat memantau status pengiriman dan penerimaan surat tanpa hambatan.</p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="card border-0 bg-primary text-white shadow-lg p-4">
                <div class="card-body">
                    <div class="row flex-wrap-reverse align-items-center">
                        <div class="col-md-6 col-12 pe-4 pb-md-4">
                            <h6 class="item-bottom">BADEAN SURAT APP</h6>
                            <h2 class="item-bottom">Ajukan Surat Sekarang</h2>
                            <p class="item-bottom">Dengan Aplikasi Mobile yang dapat kamu dapatkan dari link berikut</p>
                            <a href="<?=url("/downloadapk")?>" class="btn btn-warning item-bottom"><i class="fa-brands fa-google-play"></i> Google Play</a>
                        </div>
                        <div class="col-md-6 col-12 pb-4">
                            <center>
                                <img class="item-right" style="width: 100%; max-width: 60%;" src="<?= assets("assets/app-image.png") ?>" alt="Responsive mockup">
                            </center>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <footer class="bg-primary py-5 text-white">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6 col-12">
                    <h4><?= $data->data->nama_website ?></h4>
                    <small>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus commodi quis ea hic nostrum doloribus dignissimos non pariatur, corrupti aliquam eaque est.</small>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <ul class="list-unstyled">
                        <li class="mb-2"><small>Telepon : <?= $data->data->no_telp ?></small></li>
                        <li class="mb-2"><small>Email : <?= $data->data->email_kelurahan ?></small></li>
                        <li class="mb-2"><small>Alamat : <?= $data->data->alamat_kelurahan ?></small></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="<?= assets("bootstrap/js/bootstrap.min.js") ?>"></script>
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <script>
        // ScrollReveal().reveal('.item');
        var opt = {
            distance: '50%',
            opacity: "0",
            interval: 100,
            reset: false,
            duration: 1000,
            delay: 200,

        };
        ScrollReveal().reveal('.item-bottom', {
            origin: 'bottom',
            ...opt
        });
        ScrollReveal().reveal('.item-left', {
            origin: 'left',
            ...opt
        });
        ScrollReveal().reveal('.item-right', {
            origin: 'right',
            ...opt
        });
        ScrollReveal().reveal('.item-top', {
            origin: 'top',
            ...opt
        });
    </script>

</body>

</html>