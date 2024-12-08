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
            <a href="<?= url("/admin/kartu-keluarga") ?>" class="btn btn-secondary mb-3">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
            <div class="d-flex align-items-center">
                <div class="">
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?> </p>
                </div>
                <div class="ms-auto">
                    <button data-bs-target="#modal" data-bs-toggle="modal" class="btn btn-success me-2 text-white">
                        Foto KK
                    </button>
                    <a href="<?= url("/admin/kartu-keluarga/$data->no_kk/anggota-keluarga/create") ?>" class="btn btn-warning">
                        Tambah Anggota Keluarga
                    </a>
                </div>
            </div>


            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Status Keluarga</th>
                                <th>Tempat Tanggal Lahir</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->nik ?></td>
                                    <td><?= $kk->nama_lengkap ?></td>
                                    <td class="text-capitalize"><?= $kk->status_keluarga == "kk" ? "Kepala Keluarga" : $kk->status_keluarga ?></td>
                                    <td>
                                        <?= $kk->tempat_lahir ? $kk->tempat_lahir . ', ' : '' ?><?= formatDate($kk->tgl_lahir) ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <a href="<?= url("/admin/kartu-keluarga/$kk->no_kk/anggota-keluarga/$kk->nik/edit") ?>" title="Edit" class="btn  text-white btn-warning btn-sm">
                                                <i style="width: 15px;height: 15px;" class="fa  fa-pencil"></i>
                                            </a>
                                            <button data-url="<?= url("/admin/kartu-keluarga/$kk->no_kk/anggota-keluarga/$kk->nik/delete") ?>" title="Hapus" class="btn deleteBtn  text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                            <a href="<?= url("/admin/kartu-keluarga/$kk->no_kk/anggota-keluarga/$kk->nik") ?>" title="Detail" class="btn  text-white btn-success btn-sm">
                                                <i style="width: 15px;height: 15px;" class="fa  fa-info"></i>
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
                    <h1 class="modal-title fs-5" id="titleForm">Foto Kartu Keluarga</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content">
                    <img src="<?= $data->kk_file ?>" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>