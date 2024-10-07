<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAMDIS | <?= $title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1 p-3">
        <?php includeFile("layout/navbar") ?>
        <h3 class="mb-0 "><?= $title ?></h3>
        <p class="text-body-secondary "><?= $description ?> </p>
        <div class="card ">
            <!-- <div class="card-header bg-transparent ">
            </div> -->
            <div class="card-body">
                <form action="<?= $action_form ?>" method="post">
                    <div class="row mb-4 g-3">
                        <div class="form-group col-md-6 col-12">
                            <label for="" class="text-body-secondary ">Nama</label>
                            <input class="form-control" value="<?= $data->name ?>" type="text" placeholder="Nama pasien" name="name" id="">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="" class="text-body-secondary ">Tanggal Lahir</label>
                            <input class="form-control" value="<?= $data->birth_date ?>" type="date" name="birth-date" id="">
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label for="" class="text-body-secondary ">Nomor Telepon</label>
                            <input class="form-control" value="<?= $data->phone ?>" type="number" placeholder="Nomor Telepon" name="phone" id="">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <a href="/admin/pasien" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </main>
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
</body>

</html>