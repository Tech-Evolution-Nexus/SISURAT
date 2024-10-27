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
            <div class="d-flex align-items-center">
                <div class="">
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?> </p>
                </div>
            </div>


            <form action="<?= $data->action_form ?>" method="post" class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-12 row personal-information" style="transition: all .5s;">
                            <h6 class="mb-2  fw-bold">Informasi Kartu Keluarga</h6>
                            <input type="hidden" name="id_masyarakat">
                            <div class="col-md-6 col-12">
                                <div class="form-group  ms-3">
                                    <label for="no_kk">Nomor Kartu Keluarga<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->no_kk ?>" maxlength="16" minlength="16" type="text" class="  form-control" placeholder="Nomor Kartu Keluarga" name="no_kk" id="no_kk" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="form-group mb-2 ">
                                    <label for="tanggal_kk">Tanggal KK<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->tanggal_kk ?>" type="date" class="  form-control" placeholder="tanggal_kk" name="tanggal_kk" id="tanggal_kk" required>
                                </div>
                            </div>
                            <h6 class="mb-2 col-md-6 col-12 fw-bold">Informasi Kepala Keluarga</h6>
                            <div class="col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="no_kk">NIK Kepala Keluarga<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->nik ?>" maxlength="16" minlength="16" type="text" class="  form-control" placeholder="NIK Kepala Keluarga" name="nik" id="nik" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="nama">Nama Lengkap<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->nama ?>" type="text" class="  form-control" placeholder="Nama Lengkap" name="nama" id="nama" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 ">
                                <div class="form-group mb-2">
                                    <label for="alamat">Alamat<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->alamat ?>" type="text" class="  form-control" placeholder="Alamat Lengkap" name="alamat" id="alamat" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="form-group mb-2 ms-3">
                                    <label for="rt">RT<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->rt ?>" maxlength="2" type="text" class="  form-control" placeholder="Nomor RT" name="rt" id="rt" required>

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2">
                                    <label for="rw">RW<span class="text-danger required-password">*</span></label>
                                    <input value="<?= $data->data->rw ?>" maxlength="2" type="text" class="  form-control" placeholder="Nomor RW" name="rw" id="rw" required>
                                </div>
                            </div>
                            <h6 class="mb-2  fw-bold">Informasi Wilayah</h6>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="kelurahan">Kelurahan</label>
                                    <input value="<?= $data->data->kelurahan ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="Kelurahan" name="kelurahan" id="kelurahan" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ">
                                    <label for="kode_pos">Kode Pos</label>
                                    <input value="<?= $data->data->kode_pos ?>" maxlength="5" minlength="5" readonly type="text" class=" bg-body-secondary  form-control" placeholder="kode_pos" name="kode_pos" id="kode_pos" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="kabupaten">Kabupaten</label>
                                    <input value="<?= $data->data->kabupaten ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="kabupaten" name="kabupaten" id="kabupaten" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input value="<?= $data->data->kecamatan ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="kecamatan" name="kecamatan" id="kecamatan" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="provinsi">Provinsi</label>
                                    <input value="<?= $data->data->provinsi ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="provinsi" name="provinsi" id="provinsi" required>
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="flex mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/admin/kartu-keluarga" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>


            </form>

        </div>
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>