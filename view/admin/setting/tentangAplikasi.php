<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="<?= assets("assets/logobadean.png") ?>" type="image/x-icon">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <div class="header-layer bg-primary"></div>
    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
            <div class="row g-4">
                <div class="col-15">
                    <div class="card">
                        <div class="card-body">
                            <div class="container">
                                <form action="<?= url("admin/tentangAplikasi") ?>" enctype="multipart/form-data" method="post">
                                    <h5 class="font-weight-bold text-dark">Edit Halaman Landing Page</h5>
                                    <h6 class="font-weight-bold text-dark mt-3 mb-2">- Section Home</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="nama_website">Nama Website:</label>
                                                <input type="text" value="<?= $data->data->nama_website ?>" class="form-control shadow-sm" id="nama_website" name="nama_website">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="judul_home">Judul Halaman Home:</label>
                                                <input type="text" value="<?= $data->data->judul_home ?>" class="form-control shadow-sm" id="judul_home" name="judul_home">
                                            </div>
                                        </div>
                                        <div class="form-group mt-2">
                                            <label for="judul_home">Upload Gambar: </label>
                                            <div class="mt-2">
                                                <button class="btn btn-secondary about-button mb-2" type="button" aria-label="Edit Foto" onclick="document.getElementById('file-input').click();">
                                                    <i class="fa fa-file-image fa-2x "></i>
                                                </button>
                                                <input type="file" value="<?= $data->data->image_hero ?>" id="file-input" name="logo" accept="image/*" style="display: none;">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="deskripsi_home">Deskripsi Halaman Home:</label>
                                                <textarea class="form-control shadow-sm" id="deskripsi_home" name="deskripsi_home" rows="4"><?= $data->data->deskripsi_home ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold text-dark mt-3">- Section Tentang</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="judul_tentang">Judul Halaman Tentang:</label>
                                                <input type="text" value="<?= $data->data->judul_tentang ?>" class="form-control shadow-sm" id="judul_tentang" name="judul_tentang">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="link_download">Link Download Aplikasi:</label>
                                                <input type="text" value="<?= $data->data->link_download ?>" class="form-control shadow-sm" id="link_download" name="link_download">
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="video_url">Video:</label>
                                            <input type="text" value="<?= $data->data->video_url ?>" value="" class="form-control shadow-sm" id="video_url" name="video_url">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-3">
                                                <label for="tentang_aplikasi">Tentang Aplikasi:</label>
                                                <textarea class="form-control shadow-sm" id="tentang_aplikasi" name="tentang_aplikasi" rows="4"><?= $data->data->tentang_aplikasi ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <h6 class="font-weight-bold text-dark mt-3">- Section Footer</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-2">
                                                <label for="email_kelurahan">Email Kelurahan:</label>
                                                <input type="text" value="<?= $data->data->email_kelurahan ?>" class="form-control shadow-sm" id="email_kelurahan" name="email_kelurahan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="no_telp">No Telp:</label>
                                                <input type="text" value="<?= $data->data->no_telp ?>" class="form-control shadow-sm" id="no_telp" name="no_telp">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="alamat_kelurahan">Alamat Kelurahan:</label>
                                                <textarea class="form-control shadow-sm" id="alamat_kelurahan" name="alamat_kelurahan" rows="4"><?= $data->data->alamat_kelurahan ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <button class="btn ntn-success btn-primary fw-normal w-30" type="submit">Kirim</button>
                                    </div>
                                </form>
                            </div>
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