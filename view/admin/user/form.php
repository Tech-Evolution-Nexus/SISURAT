<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <?php includeFile("layout/sidebar") ?>
    <div class="header-layer bg-primary"></div>

    <main class="flex-grow-1">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
            <h2 class="text-white"><?= $data->title ?></h2>
            <form action="<?= $data->action_form ?>" method="post" class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input disabled type="text" name="nama_lengkap" class="form-control" value="<?= $data->data->nama_lengkap ?>" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="nik" class="form-label">Nik</label>
                        <input disabled type="number" name="nik" class="form-control" value="<?= $data->data->nik ?>" required>
                    </div>
                   
            
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input disabled type="email" name="email" class="form-control" value="<?= $data->data->email ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No. HP</label>
                        <input disabled type="text" name="no_hp" class="form-control" value="<?= $data->data->no_hp ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input disabled type="text" name="role" class="form-control" value="<?= $data->data->role ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="<?= url("/admin/users") ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </main>
</body>

</html>