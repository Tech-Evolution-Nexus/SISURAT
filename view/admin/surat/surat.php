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
                <div class="ms-auto">
                    <a href="<?= url("/admin/surat/create") ?>" class="btn btn-warning">
                        Tambah Jenis Surat
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Jenis Surat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->datasurat  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td> <img class="rounded" src="<?= url("/admin/assetssurat/$kk->image") ?>" width="80" height="80" alt="a"></td>
                                    <td><?= $kk->nama_surat ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <a href="<?= url("/admin/surat/$kk->id/edit") ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button data-url="<?= url("/admin/surat/$kk->id/delete") ?>" title="Hapus" class="btn deleteBtn  text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <a href="<?= url("/admin/surat/$kk->id") ?>" title="Detail" class="btn btnDetail text-white btn-success btn-sm">
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
        <!-- FORM MODAL -->
        <div id="modal" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="titleForm">Tambah Jenis Surat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <h5>Jenis Surat :</h5>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group  ms-3 mb-2">
                                        <label class="">Gambar surat</label>
                                        <div class="input-group ">
                                            <label class="image-upload w-100 rounded mt-2 flex-column d-flex justify-content-center align-items-center border border-dashed p-4">
                                                <input type="file" class="  form-control d-none image-upload-file" accept="image/*" placeholder="foto_kartu_keluarga" name="file_icon" id="file_icon">
                                                <i class="fa fa-image fs-1 "></i>
                                                <span>Upload File</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group  ">
                                        <label>Nama Surat</label>
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control" placeholder="Nama Surat" name="nama_surat" id="nama_surat">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <hr class="border-dark">
                            <div id="dynamic-fields">
                                <!-- Select box pertama tanpa tombol "Hapus" -->
                                <div class="d-flex justify-content-between">
                                    <h5>Detail Surat :</h5>
                                    <button type="button" id="add-field" class="btn btn-warning"><i class="fa-solid fa-plus"></i></button>
                                </div>
                                <div class="form-group ms-3" id="fselect">
                                    <label>Upoload Icon</label>
                                    <select name="fields[]" class="form-select" required>
                                        <option value="">Pilih Opsi</option>
                                        <?php foreach ($data->datalampiran  as $index => $datas) : ?>
                                            <option value="<?= $datas->id ?>"><?= $datas->nama_lampiran ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <br><br>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary fw-normal" id="btn-simpan">Simpan</button>
                                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary" id="btn-simpan">Batal</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>