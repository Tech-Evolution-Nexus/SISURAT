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
        img{

        }
    </style>

</head>

<body>
    <div class="row " style="height: 100vh;">
        <div class="col-md-7 justify-content-center d-flex flex-column align-items-center" style="background-color:#052158" > 
            <img class ="img-fluid"src="<?= assets("assets/logosurat.png") ?>" width="450">
            <h2 style="max-width:500px; text-align:center; color:white; font-size:20px;" class="mt-4">
            Kelurahan Terkoneksi, Surat Menyurat Jadi Lebih Cepat dan Mudah
    </h2>
        
        </div>
        <div class="col-md-5 p-0"> 

            <div class="bg-white p-4 d-flex flex-column items-center justify-content-center h-100">
                <img src="<?= assets("assets/logo-badean.png") ?>" alt="Medical Cross Logo" width="300" height="100">
                <h1>Login</h1>
                <p>Silahkan masukkan informasi akun untuk masuk ke aplikasi</p>
                <form action="login" method="post">
                    <div class="form-group mb-2">
                        <label for="Email" class="mb-2">Email</label>
                        <input type="text" class="form-control" placeholder="Masukkan email" name="email" id="email">
                        <?php if (isset($_SESSION["usernameErr"])): ?>
                            <small><?= $_SESSION["usernameErr"] ?></small>
                        <?php unset($_SESSION["usernameErr"]); ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password" class="mb-2">Kata sandi</label>
                        <input type="password" class="form-control" placeholder="Masukkan kata sandi" name="password" id="password">
                        <?php if (isset($_SESSION["passwordErr"])): ?>
                            <small><?= $_SESSION["passwordErr"] ?></small>
                            <?php unset($_SESSION["passwordErr"]); ?>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                    <a href="lupapassword">Lupa Password</a>
                    
                </form>
            </div>
        </div>
    </div>
</body>

</html>