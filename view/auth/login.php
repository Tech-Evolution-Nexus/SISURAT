<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT, Silahkan Login</title>
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= assets("style.css") ?>">
    <link rel="icon" href="<?= assets("assets/logobadean.png") ?>" type="image/x-icon">
    <style>
        * {
            box-sizing: border-box;
        }

        img {}
    </style>

</head>

<body>
    <div class="">
        <div class="row mx-0" style="height: 100vh;">
            <div class="col-md-7 justify-content-center d-flex flex-column align-items-center" style="background-color:#052158">
                <img class="img-fluid" src="<?= assets("assets/logosurat.png") ?>" width="450">
                <h2 style="max-width:500px; text-align:center; color:white; font-size:20px;" class="mt-4">
                    Kelurahan Terkoneksi, Surat Menyurat Jadi Lebih Cepat dan Mudah
                </h2>

            </div>
            <div class="col-md-5 p-0">

                <div class="bg-white p-4 d-flex flex-column items-center justify-content-center h-100">
                    <img src="<?= assets("assets/logo-badean.png") ?>" alt="Medical Cross Logo" width="300" height="100">
                    <h1>Login</h1>
                    <p>Silahkan masukkan informasi akun untuk masuk ke aplikasi</p>
                    <?php if (session()->has("success")): ?>
                        <div class="alert alert-success d-flex justify-content-between" role="alert">
                            <?= session()->flash("success") ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->has("error")): ?>
                        <div class="alert alert-danger d-flex justify-content-between" role="alert">
                            <?= session()->flash("error") ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="login" method="post">
                        <div class="form-group mb-2">
                            <label for="Email" class="mb-2">Email</label>
                            <input type="text" value="<?= old("email") ?>" class="form-control" placeholder="Masukkan email" name="email" id="email">
                            <?php if (session()->has("email")): ?>
                                <small class="text-danger "><?= session()->error("email") ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password" class="mb-2">Kata sandi</label>

                            <!-- code password  -->
                            <div class="position-relative">
                                <input type="password" class="form-control" placeholder="Masukkan kata sandi" name="password" id="password">
                                <button type="button" class="bg-transparent password-toggle border-0 position-absolute " style="top:50%;right:10px;transform:translateY(-50%)"><i class="fa fa-eye"></i></button>
                            </div>
                            <?php if (session()->has("password")): ?>
                                <small class="text-danger "><?= session()->error("password") ?></small>
                            <?php endif; ?>
                        </div>
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                        <div class="d-flex">
                            <a href="lupapassword" class="ms-auto mt-4 d-inline-block">Lupa Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php includeFile("layout/script") ?>

</body>

</html>