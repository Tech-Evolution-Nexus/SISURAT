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
                <div class="alert alert-success d-flex justify-content-between" role="alert">
                    <?= session()->flash("error") ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- <div class="d-flex align-items-center">
                <div class="">
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?> </p>
                </div>
            </div> -->

            <a href="<?= url("/admin/kartu-keluarga/$data->nokk/anggota-keluarga") ?>" class="btn btn-secondary mb-3">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>


            <div class="card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0"><?= $data->title ?></h4>
                </div>
                <div class="card-body">
                    <h5>Informasi Diri</h5>
                    <div class="row ms-2">
                        <div class="col-3">
                            <p>NIK</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->nik ?></h6>
                        </div>

                        <div class="col-3">
                            <p>Jenis Kelamin</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->jenis_kelamin ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Nama Lengkap</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->nama ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Tempat Lahir</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->tempat_lahir ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Tanggal Lahir</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= formatDate($data->data->tanggal_lahir) ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Agama</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->agama ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Pendidikan</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->pendidikan ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Pekerjaan</p>
                        </div>
                        <div class="col-3">
                            <h6>: <?= $data->data->pekerjaan ?></h6>
                        </div>
                    </div>
                    <h5>Informasi Status dan Identitas
                    </h5>
                    <div class="row ms-2">
                        <div class="col-3">
                            <p>Golongan Darah</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->gol_darah ?></h6>
                        </div>

                        <div class="col-3">
                            <p>Status Perkawinan</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->status_perkawinan ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Status Keluarga</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->status_keluarga === "kk" ? "Kepala Keluarga" : $data->data->status_keluarga ?></h6>
                        </div>
                        <div class="col-3">
                            <p>Kewarganegaraan</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->kewarganegaraan ?></h6>
                        </div>

                    </div>
                    <h5>Dokumen Identitas Tambahan </h5>
                    <div class="row ms-2">
                        <div class="col-3">
                            <p>No Paspor</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->no_paspor ?></h6>
                        </div>

                        <div class="col-3">
                            <p>No Kitap</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->no_kitap ?></h6>
                        </div>
                    </div>
                    <h5>Informasi Keluarga </h5>
                    <div class="row ms-2">
                        <div class="col-3">
                            <p>Nama Ayah</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->nama_ayah ?></h6>
                        </div>

                        <div class="col-3">
                            <p>Nama Ibu</p>
                        </div>
                        <div class="col-9">
                            <h6>: <?= $data->data->nama_ibu ?></h6>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>