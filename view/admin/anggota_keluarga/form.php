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
            <div class="d-flex align-items-center">
                <div class="">
                    <h2 class="mb-0 text-white"><?= $data->title ?></h2>
                    <p class="text-white text-small"><?= $data->description ?> </p>
                </div>
            </div>


            <form action="<?= $data->action_form ?>" method="post" class="card">
                <div class="card-body">
                    <!-- Informasi Diri -->
                    <div class="informasi-diri">
                        <h5>Informasi Diri</h5>
                        <div class="form-group ms-2 mb-2">
                            <label>NIK<span class="text-danger ">*</span></label></label>
                            <input type="text" name="nik" class="form-control only-number" maxlength="16" placeholder="NIK" value="<?= old("nik", $data->data->nik) ?>">
                            <?php if (session()->has("nik")): ?>
                                <small class="text-danger text-capitalize"><?= session()->error("nik") ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="row ms-0">
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Nama Lengkap<span class="text-danger ">*</span></label></label>
                                    <input type="text" name="nama" class="form-control" maxlength="50" placeholder="Nama Lengkap" value="<?= old("nama", $data->data->nama) ?>">
                                    <?php if (session()->has("nama")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("nama") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Jenis Kelamin<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="jenis_kelamin">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <?php if (session()->has("jenis_kelamin")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("jenis_kelamin") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row ms-0 form-group mb-2">
                            <div class="col">
                                <label>Tempat Lahir<span class="text-danger ">*</span></label></label>
                                <input type="text" name="tempat_lahir" class="form-control" maxlength="50" placeholder="Tempat Lahir" value="<?= old("tempat_lahir", $data->data->tempat_lahir) ?>">
                                <?php if (session()->has("tempat_lahir")): ?>
                                    <small class="text-danger text-capitalize"><?= session()->error("tempat_lahir") ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <label>Tanggal Lahir<span class="text-danger ">*</span></label></label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="<?= old("tanggal_lahir", $data->data->tanggal_lahir) ?>">
                                <?php if (session()->has("tanggal_lahir")): ?>
                                    <small class="text-danger text-capitalize"><?= session()->error("tanggal_lahir") ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row ms-0">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-2">
                                    <label>Agama<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="agama">
                                        <option <?= old("tanggal_lahir", $data->data->tanggal_lahir)  == "Islam" ? "selected" : "" ?> value="Islam">Islam</option>
                                        <option <?= old("tanggal_lahir", $data->data->tanggal_lahir)  == "Kristen" ? "selected" : "" ?> value="Kristen Protestan">Kristen Protestan</option>
                                        <option <?= old("tanggal_lahir", $data->data->tanggal_lahir)  == "Katolik" ? "selected" : "" ?> value="Katolik">Katolik</option>
                                        <option <?= old("tanggal_lahir", $data->data->tanggal_lahir)  == "Hindu" ? "selected" : "" ?> value="Hindu">Hindu</option>
                                        <option <?= old("tanggal_lahir", $data->data->tanggal_lahir)  == "Buddha" ? "selected" : "" ?> value="Buddha">Buddha</option>
                                        <option <?= old("tanggal_lahir", $data->data->tanggal_lahir)  == "Konghucu" ? "selected" : "" ?> value="Konghucu">Konghucu</option>
                                    </select>
                                    <?php if (session()->has("agama")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("agama") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-2">
                                    <label>Pendidikan<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="pendidikan">
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Diploma III/S.Muda" ? "selected" : "" ?> value="Diploma III/S.Muda">Diploma III/S.Muda</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Tidak/Belum Sekolah" ? "selected" : "" ?> value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Belum Tamat SD/Sederajat" ? "selected" : "" ?> value="Belum Tamat SD/Sederajat">Belum Tamat SD/Sederajat</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Tamat SD/Sederajat" ? "selected" : "" ?> value="Tamat SD/Sederajat">Tamat SD/Sederajat</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "SLTP" ? "selected" : "" ?> value="SLTP">SLTP/Sederajat</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "SLTA" ? "selected" : "" ?> value="SLTA">SLTA/Sederajat</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Diploma I/II" ? "selected" : "" ?> value="Diploma I/II">Diploma I/II</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Diploma IV/Strata I" ? "selected" : "" ?> value="Diploma IV/Strata I">Diploma IV/Strata I</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Strata II" ? "selected" : "" ?> value="Strata II">Strata II</option>
                                        <option <?= old("pendidikan", $data->data->pendidikan)  == "Strata III" ? "selected" : "" ?> value="Strata III">Strata III</option>
                                    </select>
                                    <?php if (session()->has("pendidikan")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("pendidikan") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Pekerjaan<span class="text-danger ">*</span></label></label>
                                    <input type="text" name="pekerjaan" class="form-control" maxlength="50" placeholder="Pekerjaan" value="<?= old("pekerjaan", $data->data->pekerjaan) ?>">
                                    <?php if (session()->has("pekerjaan")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("pekerjaan") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Status dan Identitas -->
                    <div class="informasi-status mt-4">
                        <h5>Informasi Status dan Identitas</h5>
                        <div class="row ms-0">
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-2">
                                    <label>Golongan Darah<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="gol_darah">
                                        <option <?= old("gol_darah", $data->data->gol_darah) === "O" ? "selected" : "" ?> value="O">O</option>
                                        <option <?= old("gol_darah", $data->data->gol_darah) === "A" ? "selected" : "" ?> value="A">A</option>
                                        <option <?= old("gol_darah", $data->data->gol_darah) === "B" ? "selected" : "" ?> value="B">B</option>
                                        <option <?= old("gol_darah", $data->data->gol_darah) === "AB" ? "selected" : "" ?> value="AB">AB</option>
                                        <option <?= old("gol_darah", $data->data->gol_darah) === "-" ? "selected" : "" ?> value="-">-</option>
                                    </select>
                                    <?php if (session()->has("pekerjaan")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("pekerjaan") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Status Perkawinan<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="status_perkawinan">
                                        <option <?= old("status_perkawinan", $data->data->status_perkawinan) === "Belum Kawin" ? "selected" : "" ?> value="Belum Kawin">Belum Kawin</option>
                                        <option <?= old("status_perkawinan", $data->data->status_perkawinan) === "Kawin" ? "selected" : "" ?> value="Kawin">Kawin</option>
                                        <option <?= old("status_perkawinan", $data->data->status_perkawinan) === "Cerai" ? "selected" : "" ?> value="Cerai">Cerai</option>
                                    </select>
                                    <?php if (session()->has("status_perkawinan")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("status_perkawinan") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Tanggal Perkawinan<span class="text-danger ">*</span></label></label>
                                    <input type="date" name="tgl_perkawinan" class="form-control" value="<?= old("tgl_perkawinan", $data->data->tgl_perkawinan) ?>">
                                    <?php if (session()->has("tgl_perkawinan")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("tgl_perkawinan") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Status Keluarga<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="status_keluarga">
                                        <?php if ($data->data->status_keluarga === "kk"): ?>
                                            <option <?= old("status_keluarga", $data->data->status_keluarga) === "kk" ? "selected" : "" ?> value="kk">Kepala Keluarga</option>
                                        <?php endif; ?>
                                        <option <?= old("status_keluarga", $data->data->status_keluarga) === "istri" ? "selected" : "" ?> value="istri">Istri</option>
                                        <option <?= old("status_keluarga", $data->data->status_keluarga) === "anak" ? "selected" : "" ?> value="anak">Anak</option>
                                        <option <?= old("status_keluarga", $data->data->status_keluarga) === "wali" ? "selected" : "" ?> value="wali">Wali</option>
                                    </select>
                                    <?php if (session()->has("status_keluarga")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("status_keluarga") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Kewarganegaraan<span class="text-danger ">*</span></label></label>
                                    <select class="form-select" name="kewarganegaraan">
                                        <option <?= old("kewarganegaraan", $data->data->kewarganegaraan === "WNI" ? "selected" : "") ?> value="WNI">WNI</option>
                                        <option <?= old("kewarganegaraan", $data->data->kewarganegaraan === "WNA" ? "selected" : "") ?> value="WNA">WNA</option>
                                    </select>
                                    <?php if (session()->has("kewarganegaraan")): ?>
                                        <small class="text-danger text-capitalize"><?= session()->error("kewarganegaraan") ?></small>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Identitas Tambahan -->
                    <div class="dokumen-identitas mt-4">
                        <h5>Dokumen Identitas Tambahan</h5>
                        <div class="row ms-0 form-group mb-2">
                            <div class="col">
                                <label>No Paspor</label></label>
                                <input type="text" name="no_paspor" class="form-control only-number" maxlength="50" placeholder="No Paspor" value="<?= old("no_paspor", $data->data->no_paspor) ?>">
                                <?php if (session()->has("no_paspor")): ?>
                                    <small class="text-danger text-capitalize"><?= session()->error("no_paspor") ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <label>No KITAP</label></label>
                                <input type="text" name="no_kitap" class="form-control only-number" maxlength="50" placeholder="No KITAP" value="<?= old("no_kitap", $data->data->no_kitap) ?>">
                                <?php if (session()->has("no_kitap")): ?>
                                    <small class="text-danger text-capitalize"><?= session()->error("no_kitap") ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Keluarga -->
                    <div class="informasi-keluarga mt-4">
                        <h5>Informasi Keluarga</h5>
                        <div class="row ms-0 form-group">
                            <div class="col">
                                <label>Nama Ayah<span class="text-danger ">*</span></label></label>
                                <input type="text" name="nama_ayah" class="form-control" maxlength="50" placeholder="Nama Ayah" value="<?= old("nama_ayah", $data->data->nama_ayah) ?>">
                                <?php if (session()->has("nama_ayah")): ?>
                                    <small class="text-danger text-capitalize"><?= session()->error("nama_ayah") ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col">
                                <label>Nama Ibu<span class="text-danger ">*</span></label></label>
                                <input type="text" name="nama_ibu" class="form-control" maxlength="50" placeholder="Nama Ibu" value="<?= old("nama_ibu", $data->data->nama_ibu) ?>">
                                <?php if (session()->has("nama_ibu")): ?>
                                    <small class="text-danger text-capitalize"><?= session()->error("nama_ibu") ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="<?= url("/admin/kartu-keluarga/$data->nokk/anggota-keluarga") ?>" class="btn btn-secondary">Kembali</a>
                    </div>

                </div>


            </form>

        </div>
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>