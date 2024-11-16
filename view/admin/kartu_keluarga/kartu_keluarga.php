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

                    <button data-bs-toggle="modal" data-bs-target="#modal" class="btn btn-success text-white">
                        Import
                    </button>

                    <a href="<?= url("/admin/kartu-keluarga/create") ?>" class="btn btn-warning">
                        Tambah KK
                    </a>
                </div>
            </div>



            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No KK</th>
                                <th>Nama Lengkap</th>
                                <th>Alamat</th>
                                <th>RW</th>
                                <th>RT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->no_kk ?></td>
                                    <td><?= $kk->nama_lengkap ?></td>
                                    <td><?= $kk->alamat ?></td>
                                    <td><?= $kk->rw ?></td>
                                    <td><?= $kk->rt ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <a href="<?= url("/admin/kartu-keluarga/$kk->no_kk/edit") ?>" title="Edit" class="btn  text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <button data-url="<?= url("/admin/kartu-keluarga/$kk->no_kk/delete") ?>" title="Hapus" class="btn deleteBtn  text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <!-- <a  href="<?= url("/admin/kartu-keluarga/$kk->no_kk/delete") ?>" title="Hapus" class="btn  text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a> -->


                                            <a href="<?= url("/admin/kartu-keluarga/$kk->no_kk/anggota-keluarga") ?>" title="Detail" class="btn  text-white btn-success btn-sm">
                                                <i class="fa fa-users"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>



    <!-- FORM MODAL -->
    <div id="modal" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="titleForm">Import Kartu Keluarga</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= url("/admin/kartu-keluarga/import") ?>" enctype="multipart/form-data" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <button class="btn btn-success text-white mb-2">Download Template Import</button>
                        </div>
                        <div class="form-group">
                            <label for="">File excel</label>
                            <input accept=".xls,.xlsx" type="file" class="form-control" name="file" id="file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary fw-normal">Import</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
            </div>
            </form>
        </div>

    </div>
    </div>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>