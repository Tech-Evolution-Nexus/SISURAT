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


            <?php
            // dd(session()->all()  );
            ?>
            <form action="<?= $data->action_form ?>" method="post" class="card">
                <div class="card-body">
                    <!-- Informasi Diri -->
                    <div class="informasi-diri">
                        <h5>Informasi Diri</h5>
                        <div class="form-group ms-2 mb-2">
                            <label>NIK</label>
                            <input type="text" name="nik" class="form-control" maxlength="50" placeholder="NIK" value="3512021501890020">
                        </div>
                        <div class="row ms-0">
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" maxlength="50" placeholder="Nama Lengkap" value="Joko">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-select" name="kelamin">
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row ms-0 form-group mb-2">
                            <div class="col">
                                <label>Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" maxlength="50" placeholder="Tempat Lahir" value="XX">
                            </div>
                            <div class="col">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="1989-01-15">
                            </div>
                        </div>
                        <div class="row ms-0">
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Agama</label>
                                    <select class="form-select" name="agama">
                                        <option value="Islam">Islam</option>
                                        <option value="Kristen Protestan">Kristen Protestan</option>
                                        <option value="Katolik">Katolik</option>
                                        <option value="Hindu">Hindu</option>
                                        <option value="Buddha">Buddha</option>
                                        <option value="Konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group mb-2">
                                    <label>Pendidikan</label>
                                    <select class="form-select" name="pendidikan">
                                        <option value="Diploma III/S.Muda">Diploma III/S.Muda</option>
                                        <option value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                                        <option value="Belum Tamat SD/Sederajat">Belum Tamat SD/Sederajat</option>
                                        <option value="Tamat SD/Sederajat">Tamat SD/Sederajat</option>
                                        <option value="SLTP">SLTP/Sederajat</option>
                                        <option value="SLTA">SLTA/Sederajat</option>
                                        <option value="Diploma I/II">Diploma I/II</option>
                                        <option value="Diploma IV/Strata I">Diploma IV/Strata I</option>
                                        <option value="Strata II">Strata II</option>
                                        <option value="Strata III">Strata III</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" maxlength="50" placeholder="Pekerjaan" value="Dosen">
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
                                    <label>Golongan Darah</label>
                                    <select class="form-select" name="gol_darah">
                                        <option value="O">O</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="-">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Status Perkawinan</label>
                                    <select class="form-select" name="status_perkawinan">
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai">Cerai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Tanggal Perkawinan</label>
                                    <input type="date" name="tgl_perkawinan" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Status Keluarga</label>
                                    <select class="form-select" name="status_keluarga">
                                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Wali">Wali</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">

                                <div class="form-group mb-2">
                                    <label>Kewarganegaraan</label>
                                    <select class="form-select" name="kewarganegaraan">
                                        <option value="WNI">WNI</option>
                                        <option value="WNA">WNA</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Identitas Tambahan -->
                    <div class="dokumen-identitas mt-4">
                        <h5>Dokumen Identitas Tambahan</h5>
                        <div class="row ms-0 form-group mb-2">
                            <div class="col">
                                <label>No Paspor</label>
                                <input type="text" name="no_paspor" class="form-control" maxlength="50" placeholder="No Paspor" value="123">
                            </div>
                            <div class="col">
                                <label>No KITAP</label>
                                <input type="text" name="no_kitap" class="form-control" maxlength="50" placeholder="No KITAP" value="123">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Keluarga -->
                    <div class="informasi-keluarga mt-4">
                        <h5>Informasi Keluarga</h5>
                        <div class="row ms-0 form-group">
                            <div class="col">
                                <label>Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control" maxlength="50" placeholder="Nama Ayah" value="Hamsus">
                            </div>
                            <div class="col">
                                <label>Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control" maxlength="50" placeholder="Nama Ibu" value="Agustin">
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-4">
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