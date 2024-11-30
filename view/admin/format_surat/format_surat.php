<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
    <style>
        .no-bootstrap,
        .no-bootstrap * {
            all: revert;
            font-size: 7px;
            line-height: 1.2;
            max-height: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview,
        .preview * {
            all: revert;
            font-size: 16px;
            line-height: 1.2;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview img {
            display: none;
        }
    </style>
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
            <div class="d-flex align-items-center flex-wrap mb-4">
                <div>
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?></p>
                </div>

                <!-- <div class="ms-auto d-flex gap-2">
                    <a href="<?= url("/admin/format-surat/create") ?>" class="btn btn-warning">
                        Tambah Format Surat
                    </a>
                </div> -->
            </div>
            <div class="row align-items-stretch g-4">
                <?php foreach ($data->data as $formatSurat): ?>
                    <div class="col-md-4 col-sm-6 col-12 overflow-hidden">
                        <article class="card h-100" style="max-width: 100%;">
                            <div class="card-body ">
                                <div class=" no-bootstrap">
                                    <?= $formatSurat->format_surat ?>
                                </div>

                                <h6 class="mt-4 fw-bold"><?= $formatSurat->nama_surat ?></h6>
                                <div class="d-flex mt-4 gap-2">
                                    <a href="<?= url("/admin/format-surat/$formatSurat->id/edit") ?>" class="btn btn-warning text-white" title="Ubah"><i class="fa fa-pencil"></i></a>
                                    <button data-bs-toggle="modal" data-bs-target="#modal<?= $formatSurat->id ?>" class="btn btn-success text-white" title="Preview"><i class="fa fa-eye"></i></>
                                </div>
                            </div>
                        </article>
                        <div id="modal<?= $formatSurat->id ?>" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
                            <div class="modal-dialog  modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="titleForm">Preview Surat</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body ">
                                        <div class="preview">
                                            <?= $formatSurat->format_surat ?>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>





    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>