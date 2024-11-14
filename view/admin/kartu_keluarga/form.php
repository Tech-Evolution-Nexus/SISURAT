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
                    <div class="row">

                        <div class="col-12 row personal-information" style="transition: all .5s;">
                            <h6 class="mb-2  fw-bold">Informasi Kartu Keluarga</h6>
                            <input type="hidden" name="id_masyarakat">
                            <div class="col-md-6 col-12">
                                <div class="form-group  ms-3">
                                    <label for="no_kk">Nomor Kartu Keluarga<span class="text-danger only-number">*</span></label>
                                    <input value="<?= old("no_kk", $data->data->no_kk) ?>" maxlength="16" minlength="16" type="text" class=" only-number form-control" placeholder="Nomor Kartu Keluarga" name="no_kk" id="no_kk" required>
                                    <?php if (session()->has("no_kk")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("no_kk") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="form-group mb-2 ">
                                    <label for="tanggal_kk">Tanggal KK<span class="text-danger ">*</span></label>
                                    <input value="<?= old("tanggal_kk", $data->data->tanggal_kk) ?>" type="date" class="  form-control " placeholder="tanggal_kk" name="tanggal_kk" id="tanggal_kk" required>
                                    <?php if (session()->has("tanggal_kk")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("tanggal_kk") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2 ms-3">
                                <div class="form-group mb-2 ">
                                    <label for="foto_kartu_keluarga">Foto Kartu Keluarga</label>
                                    <label style="background-image: url(<?= $data->data->foto_kartu_keluarga ?>);" class="image-upload rounded mt-2 flex-column d-flex justify-content-center align-items-center border border-dashed p-4">
                                        <input value="<?= old("foto_kartu_keluarga", $data->data->foto_kartu_keluarga) ?>" type="file" class="  form-control d-none image-upload-file" accept="image/*" placeholder="foto_kartu_keluarga" name="foto_kartu_keluarga" id="foto_kartu_keluarga">
                                        <i class="fa fa-image fs-1"></i>
                                        <span>Upload File</span>
                                    </label>
                                    <?php if (session()->has("foto_kartu_keluarga")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("foto_kartu_keluarga") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <h6 class="mb-2  col-12 fw-bold">Informasi Kepala Keluarga</h6>
                            <div class="col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="no_kk">NIK Kepala Keluarga<span class="text-danger only-number">*</span></label>
                                    <input value="<?= old("nik", $data->data->nik) ?>" maxlength="16" minlength="16" type="text" class=" only-number form-control" placeholder="NIK Kepala Keluarga" name="nik" id="nik" required>
                                    <?php if (session()->has("nik")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("nik") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="nama">Nama Lengkap<span class="text-danger ">*</span></label>
                                    <input value="<?= old("nama", $data->data->nama) ?>" type="text" class="  form-control" placeholder="Nama Lengkap" name="nama" id="nama" required>
                                    <?php if (session()->has("nama")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("nama") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 ">
                                <div class="form-group mb-2">
                                    <label for="alamat">Alamat<span class="text-danger ">*</span></label>
                                    <input value="<?= old("alamat", $data->data->alamat) ?>" type="text" class="  form-control" placeholder="Alamat Lengkap" name="alamat" id="alamat" required>
                                    <?php if (session()->has("alamat")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("alamat") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-2">
                                <div class="form-group mb-2 ms-3">
                                    <label for="rt">RT<span class="text-danger ">*</span></label>
                                    <input value="<?= old("rt", $data->data->rt) ?>" maxlength="2" type="text" class=" only-number  form-control" placeholder="Nomor RT" name="rt" id="rt" required>
                                    <?php if (session()->has("rt")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("rt") ?></small>
                                    <?php endif; ?>

                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2">
                                    <label for="rw">RW<span class="text-danger ">*</span></label>
                                    <input value="<?= old("rw", $data->data->rw) ?>" maxlength="2" type="text" class=" only-number form-control" placeholder="Nomor RW" name="rw" id="rw" required>
                                    <?php if (session()->has("rw")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("rw") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <h6 class="mb-2  fw-bold">Informasi Wilayah</h6>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="kelurahan">Kelurahan</label>
                                    <input value="<?= old("kelurahan", $data->data->kelurahan) ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="Kelurahan" name="kelurahan" id="kelurahan" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ">
                                    <label for="kode_pos">Kode Pos</label>
                                    <input value="<?= old("kode_pos", $data->data->kode_pos) ?>" maxlength="5" minlength="5" readonly type="text" class=" bg-body-secondary  form-control" placeholder="kode_pos" name="kode_pos" id="kode_pos" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="kabupaten">Kabupaten</label>
                                    <input value="<?= old("kabupaten", $data->data->kabupaten) ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="kabupaten" name="kabupaten" id="kabupaten" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ">
                                    <label for="kecamatan">Kecamatan</label>
                                    <input value="<?= old("kecamatan", $data->data->kecamatan) ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="kecamatan" name="kecamatan" id="kecamatan" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group mb-2 ms-3">
                                    <label for="provinsi">Provinsi</label>
                                    <input value="<?= old("provinsi", $data->data->provinsi) ?>" readonly type="text" class=" bg-body-secondary  form-control" placeholder="provinsi" name="provinsi" id="provinsi" required>
                                </div>
                            </div>
                        </div>

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