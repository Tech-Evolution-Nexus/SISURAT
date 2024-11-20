<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <div class="header-layer bg-primary"></div>
    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1 ">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
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
            <div class="d-flex align-items-center">
                <div class="">
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?> </p>
                </div>
            </div>


            <form action="<?= $data->action_form ?>" method="post" class="card" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Nama Format</label>
                        <input value="<?= old("nama", $data->data->nama) ?>" type="text" name="nama" class="form-control" id="">
                        <?php if (session()->has("nama")): ?>
                            <small class="text-danger text-capitalize"><?= session()->error("nama") ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="">Konten</label>
                        <textarea name="konten" class="editor" id="">
                            <?= old("konten", $data->data->konten) ?>
                        </textarea>
                        <?php if (session()->has("konten")): ?>
                            <small class="text-danger text-capitalize"><?= session()->error("konten") ?></small>
                        <?php endif; ?>
                    </div>
                    <div class="flex mt-4">
                        <button type="submit" class="btn btn-primary fw-normal">Simpan</button>
                        <a href="<?= url("/admin/kartu-keluarga") ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>


            </form>

        </div>
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>