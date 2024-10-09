<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN </title>
    <link href="<?= assets("css/main.css") ?>" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= assets("style.css") ?>">
    <style>
        * {
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <div class="row " style="height: 100vh;">
        <div class="col-md-8" style="background-image: url(<?= assets('assets/bg-desa.png') ?>);">

        </div>
        <div class="col-md-4 p-0">
            <div class="bg-white p-4 d-flex flex-column items-center justify-content-center h-100">
                <h1>Badean</h1>
                <h1>Login</h1>
                <p>Silahkan masukkan informasi akun untuk masuk ke aplikasi</p>
                <form action="" method="post">
                    <div class="form-group mb-2">
                        <label for="" class="mb-2">Username</label>
                        <input type="text" class="form-control" placeholder="Masukkan username" name="" id="">
                    </div>
                    <div class="form-group mb-4">
                        <label for="" class="mb-2">Kata sandi</label>
                        <input type="text" class="form-control" placeholder="Masukkan kata sandi" name="" id="">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>