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

        body {
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
            <h1 class="text-center mb-3">Jelajahi Berita</h1>
            <form action="" method="get">
                <div class="d-flex gap-2 justify-content-center">
                    <input style="max-width: 60%;" type="text" placeholder="Cari " name="" id="" class="form-control">
                    <button class="btn btn-warning">Cari</button>
                </div>
            </form>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row g-4">
                <?php foreach ($data->berita as $berita): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <a href="<?= url("admin/berita/$berita->id") ?>">
                            <article class="card overflow-hidden text-">
                                <div class="card-body p-0">
                                    <figure class="mb-0">
                                        <img class="img-fluid" src="<?= url("admin/assetsberita/" . $berita->gambar) ?>" alt="">
                                    </figure>
                                    <div class="p-3">
                                        <h6><?= $berita->judul ?></h6>
                                        <p class="mb-1"><?= $berita->sub_judul ?></p>
                                        <small><?= formatDate($berita->created_at) ?></small>
                                    </div>
                                </div>
                            </article>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <footer class="bg-primary py-5 text-white">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-6 col-12">
                    <h4><?= $data->landing->nama_website ?></h4>
                    <small>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus commodi quis ea hic nostrum doloribus dignissimos non pariatur, corrupti aliquam eaque est.</small>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <ul class="list-unstyled">
                        <li class="mb-2"><small>Telepon : <?= $data->landing->no_telp ?></small></li>
                        <li class="mb-2"><small>Email : <?= $data->landing->email_kelurahan ?></small></li>
                        <li class="mb-2"><small>Alamat : <?= $data->landing->alamat_kelurahan ?></small></li>
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
            reset: true,
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