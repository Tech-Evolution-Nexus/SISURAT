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
                <div>
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?></p>
                </div>

                <div class="ms-auto d-flex gap-2">
                    <a href="<?= url("/admin/format-surat/create") ?>" class="btn btn-warning">
                        Tambah Format Surat
                    </a>
                </div>
            </div>
            <div class="row">
                <?php foreach ($data->data as $formatSurat): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <article class="card">
                            <div class="card-body">
                                <?= $formatSurat->nama ?>
                                <div class="d-flex">
                                    <a href=""></a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>



        </div>
    </main>



    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>