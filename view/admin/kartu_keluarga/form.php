<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAMDIS | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <div class="header-layer bg-primary"></div>

    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1 ">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
            <h3 class="mb-0 text-white "><?= $data->title ?></h3>
            <p class="text-white text-small"><?= $data->description ?> </p>
            <div class="card ">
                <div class="card-body">
                    <form action="<?= $action_form ?>" method="post">
                        <div class="row mb-4 g-3">
                            <div class="form-group col-md-6 col-12">
                                <label for="no_kk" class="text-body-secondary ">Nomor KK</label>
                                <input class="form-control" value="<?= $data->data->no_kk ?>" type="text" placeholder="Nama pasien" name="no_kk" id="no_kk">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="kepala_keluarga" class="text-body-secondary ">Kepala Keluarga</label>
                                <select name="kepala_keluarga" class="form-control select2" id="kepala_keluarga">
                                    <option>Silahkan pilih kepala keluarga</option>
                                </select>
                            </div>
                            <div class="form-group  col-12">
                                <label for="alamat" class="text-body-secondary ">Alamat</label>
                                <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat kartu keluarga"></textarea>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="rt" class="text-body-secondary ">RT</label>
                                <input class="form-control" placeholder="Nomor RT" value="<?= $data->data->rt ?>" type="text" name="rt" id="rt">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label for="rw" class="text-body-secondary ">RW</label>
                                <input class="form-control" placeholder="Nomor RW" value="<?= $data->data->rw ?>" type="text" name="rw" id="rw">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Simpan</button>
                        <a href="/admin/pasien" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
</body>

</html>