<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISURAT BADEAN</title>
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">

</head>

<body>


    <nav class="navbar navbar-expand-lg bg-primary position-sticky top-0 left-0 w-100">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="<?= assets("assets/logo-badean.png") ?>" style="width: 150px;" alt=""></a> <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-md-4">
                    <li class="nav-item">
                        <a class="nav-link text-white " aria-current="page" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Berita</a>
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
                    <h1>Smart App Pengajuan Surat menyurat</h1>
                    <p>Sebagai wujud komitmen dalam memberikan informasi seluas-seluasnya kepada masyarakat. Smart App akan mempermudahkan dalam proses pengajuan surat yang dilakukan oleh masyarakat.</p>
                    <!-- <button class="btn btn-primary px-5 mb-4 me-2">
                        <i class="fa fa-download"></i>
                    Login
                    </button> -->
                    <a href="https://github.com/Kholzt" class="btn btn-warning mb-4"><i class="fa fa-envelope"></i> Pengajuan Surat</a>


                </div>

            </div>
        </div>
    </section>
    <script src="<?= assets("bootstrap/js/bootstrap.min.js") ?>"></script>

</body>

</html>