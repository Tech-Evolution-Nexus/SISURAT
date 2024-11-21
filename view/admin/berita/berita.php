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
                    <button type="button" class="btn btn-warning" id="add-btn" data-bs-toggle="modal" data-bs-target="#modal">
                        Tambah Berita
                    </button>
                </div>
            </div>
            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Judul</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $berita) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td> <img src="<?= url("/admin/assetsberita/$berita->gambar") ?>" width="32" height="32" alt="a"></td>
                                    <td><?= $berita->judul ?></td>
                                    <td><?= $berita->sub_judul ?></td>

                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <button data-id="<?= $berita->id ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button data-id="<?= $berita->id ?>" title="Hapus" class="btn btnDelete text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>

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
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="titleForm">Tambah Berita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-6 col-12 ">
                                    <label class="">Thumbnail</label>
                                    <div class="input-group ">
                                        <label for=""></label>
                                        <label class="image-upload w-100 rounded mt-2 flex-column d-flex justify-content-center align-items-center border border-dashed p-4">
                                            <input type="file" class="  form-control d-none image-upload-file" accept="image/*" placeholder="file_berita" name="file_berita" id="file_berita">
                                            <i class="fa fa-image fs-1 "></i>
                                            <span>Upload File</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group mb-2">
                                        <label>Judul </label>
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control" placeholder="Masukan Judul Berita" name="judul" id="judul">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label>Keterangan</label>
                                        <div class="input-group mt-2">
                                            <input type="text" class="form-control" placeholder="Masukan SubJudul Berita" name="subjudul" id="subjudul">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  mt-2">
                                    <label class="mb-2">Konten</label>
                                    <textarea name="deskripsi" id="deskripsi" class="deskripsi"></textarea>
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

    <script>
        let editorInstance;
        ClassicEditor
            .create(document.querySelector('.deskripsi'), {
                toolbar: [
                    'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
                    'alignment', 'bulletedList', 'numberedList', '|',
                    'link', 'blockQuote', 'insertTable', '|',
                    'heading', '|',
                    'code', 'codeBlock', '|',
                    'removeFormat'
                ],
            })
            .then(editor => {
                editorInstance = editor;
            })
            .catch(error => {
                console.error('There was a problem initializing the editor:', error);
            });
        $("#add-btn").on("click", function() {
            setupForm("Tambah Berita", "<?= url("/admin/berita") ?>")
            $("[name=judul]").attr('required');
            $("[name=subjudul]").attr('required');
            $("[name=deskripsi]").attr('required');
            $("[name=file_berita]").attr('required');
            $(".modal form").trigger("reset");
            $(".personal-information, .modal-footer").css({
                height: 0,
                opacity: 0
            })
            $(".image-upload").css("background-image", `url("")`)

        })
        $(".editBtn").on("click", function() {
            const id = $(this).attr("data-id")

            setupForm("Ubah Berita", `<?= url("/admin/editberita/") ?>${id}`);

            $(".modal").modal("show")
            $.ajax({
                url: "/SISURAT/admin/getberita/" + id,
                success: (data) => {
                    console.log(data.data)
                    setFormData(data.data)
                }
            })
        })
        const setupForm = (title, action) => {
            $("#titleForm").text(title)
            $(".modal form").attr("action", action)
        }
        const setFormData = ({
            id,
            judul,
            sub_judul,
            deskripsi,
            gambar,

        }) => {

            $("[name=judul]").val(judul)
            $("[name=subjudul]").val(sub_judul)
            $(".image-upload").css("background-image", `url(${gambar})`)

            if (editorInstance) {
                editorInstance.setData(deskripsi); // Mengatur konten CKEditor 5
            } else {
                console.error("Editor belum siap.");
            }
            // $("[name=file_berita]").val(gambar)

        }
        document.querySelectorAll('.btnDelete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {

                        fetch(`<?= url('/admin/deleteberita/') ?>${id}`, {
                                method: 'POST'
                            })
                            .then(response => {
                                if (response.ok) {
                                    Swal.fire(
                                        'Dihapus!',
                                        'Data telah dihapus.',
                                        'success'
                                    ).then(() => {
                                        location.reload(); // Reload halaman setelah dihapus
                                    });
                                } else {
                                    Swal.fire(
                                        'Gagal!',
                                        'Terjadi kesalahan saat menghapus data.',
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            });
                    }
                });
            });
        });
    </script>
</body>

</html>