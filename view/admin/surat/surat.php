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
                <div class="ms-auto">
                    <button type="button" class="btn btn-warning" id="add-btn" data-bs-toggle="modal" data-bs-target="#modal">
                        Tambah Jenis Surat
                    </button>
                </div>
            </div>


            <!-- FORM MODAL -->
            <div id="modal" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="titleForm">Tambah Jenis Surat</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">


                            <form action="surat" method="POST" enctype="multipart/form-data">
                                <h5>Jenis Surat :</h5>
                                <div class="form-group mt-3 ms-3">
                                    <label>Nama Surat</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Nama Surat" name="nama_surat">
                                    </div>
                                    <label class="mt-3">Upoload Icon</label>
                                    <div class="input-group ">
                                        <input type="file" class="form-control-file" name="file_icon" accept="image/*">
                                    </div>
                                </div>
                                <hr>
                                <div id="dynamic-fields">
                                    <!-- Select box pertama tanpa tombol "Hapus" -->
                                    <div class="d-flex justify-content-between">
                                        <h5>Detail Surat :</h5>
                                        <button type="button" id="add-field" class="btn btn-warning"><i class="fa-solid fa-plus"></i></button>
                                    </div>


                                    <div class="form-group ms-3">
                                        <label>Upoload Icon</label>
                                        <select name="fields[]" class="form-select" required>
                                            <option value="">Pilih Opsi</option>
                                            <option value="Opsi 1">Opsi 1</option>
                                            <option value="Opsi 2">Opsi 2</option>
                                            <option value="Opsi 3">Opsi 3</option>
                                        </select>
                                    </div>
                                </div>

                                <br><br>
                                <button type="submit" class="btn btn-success">Kirim</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Surat</th>
                                <th>Icon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->nama_surat ?></td>
                                    <td><?= $kk->image ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <button data-id="<?= $kk->id ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <a href="" title="Hapus" class="btn  text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="" title="Detail" class="btn  text-white btn-success btn-sm">
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
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
    <script>
        function addField() {
            const dynamicFields = document.getElementById("dynamic-fields");
            const formGroup = document.createElement("div");
            formGroup.className = "form-group";
            formGroup.innerHTML = `
            <div class="d-flex ms-3 mt-3">
                <select name="fields[]" class="form-select" required>
                    <option value="">Pilih Opsi</option>
                    <option value="Opsi 1">Opsi 1</option>
                    <option value="Opsi 2">Opsi 2</option>
                    <option value="Opsi 3">Opsi 3</option>
                </select>
                <button type="button" class="btn btn-danger ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
            dynamicFields.appendChild(formGroup);
        }

        function removeField(button) {
            button.parentNode.remove();
        }

        document.getElementById("add-field").addEventListener("click", addField);
    </script>
</body>

</html>