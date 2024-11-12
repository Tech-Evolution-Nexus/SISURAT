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
                        Tambah Jenis Surat
                    </button>
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
                            <?php foreach ($data->datasurat  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->nama_surat ?></td>
                                    <td> <img src="<?= url("/admin/assets/$kk->image") ?>" width="32"height="32" alt="a"></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <button data-id="<?= $kk->id ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <button data-id="<?= $kk->id ?>" title="Hapus" class="btn btnDelete text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <button data-id="<?= $kk->id ?>" title="Detail" class="btn btnDetail text-white btn-success btn-sm">
                                                <i class="fa fa-users"></i>
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="titleForm">Tambah Jenis Surat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <h5>Jenis Surat :</h5>
                            <div class="form-group mt-3 ms-3">
                                <label>Nama Surat</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Nama Surat" name="nama_surat" id="nama_surat">
                                </div>
                                <label class="mt-3">Upoload Icon</label>
                                <div class="input-group ">
                                    <input type="file" class="form-control-file" name="file_icon" accept="image/*" id="file_icon">
                                </div>
                            </div>
                            <hr>
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
                            <button type="submit" class="btn btn-success" id="btn-simpan">Simpan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
    <script>
        $("#add-btn").on("click", function() {
            setupForm("Tambah Jenis Surat", "<?= url("/admin/surat") ?>")
            $("[name=nama_surat]").attr('required');
            $('#fselect').remove();
            $('.fselected').remove();
            $('#add-field').show()
            $('#btn-simpan').show()
            $('#file_icon').show();
            $(".modal form").trigger("reset");
            $(".personal-information, .modal-footer").css({
                height: 0,
                opacity: 0
            })
            removeLampiranInput()
            addField()
        })
        $(".editBtn").on("click", function() {
            const id = $(this).attr("data-id")

            setupForm("Ubah Jenis Surat", ` <?= url("/admin/editsurat/") ?>${id}`);
            $(".modal").modal("show")
            $.ajax({
                url: "/SISURAT/admin/esurat/" + id,
                success: (data) => {
                    $('#fselect').remove();
                    $('.fselected').remove();
                    $('#add-field').show()
                    $('#btn-simpan').show()
                    $('#file_icon').show();

                    $("[name=nama_surat]").prop('disabled', false);
                    removeLampiranInput()
                    data.datalampiran.forEach((element, index) => {
                        const dynamicFields = document.getElementById("dynamic-fields");
                        const formGroup = document.createElement("div");
                        formGroup.className = "form-group";
                        formGroup.innerHTML = `
                       <div class="mt-3 fselected">
                        <label>Data ${index+1}</label>
                        <div class="d-flex ms-3  ">
                            <select name="fields[]" class="form-select" required>
                                <option value="">Pilih Opsi</option>
                                <?php foreach ($data->datalampiran  as $index => $datas) : ?>
                                <option ${element.id==<?= $datas->id ?>?"selected":""} value="<?= $datas->id ?>"><?= $datas->nama_lampiran ?></option>
                                <?php endforeach; ?>
                                </select>
                                ${index!=0?'<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>':''}
                            </div></div>
                        `;

                        dynamicFields.appendChild(formGroup);
                    });
                    setFormData(data.datasurat)
                }
            })
        })

        $(".btnDetail").on("click", function() {
            const id = $(this).attr("data-id")

            setupForm("Detail Jenis Surat", "");
            $(".modal").modal("show")
            $.ajax({
                url: "/SISURAT/admin/esurat/" + id,
                success: (data) => {
                    $('#fselect').hide()
                    $('.fselected').hide()
                    $('#add-field').hide()
                    $('#btn-simpan').hide()
                    $('#file_icon').hide();

                    $("[name=nama_surat]").attr('disabled', true);
                    removeLampiranInput()
                    data.datalampiran.forEach((element, index) => {
                        const dynamicFields = document.getElementById("dynamic-fields");
                        const formGroup = document.createElement("div");
                        formGroup.className = "form-group";
                        formGroup.innerHTML = `
                         <div class="form-group mt-3 ms-3">
                            <label>Data ${index+1}</label>
                                <div class="input-group">
                                    <input class="form-control" name="data-${index}" id="data${index}" value="${element.nama_lampiran}" disabled/>
                                </div>
                        </div>
                        `;

                        dynamicFields.appendChild(formGroup);
                    });
                    setFormData(data.datasurat)
                }
            })
        })


        const removeLampiranInput = () => {
            const dynamicFields = document.getElementById("dynamic-fields");
            const countInput = $(dynamicFields).children(".form-group").remove()

            const allSelects = document.querySelectorAll('[name="fields[]"]');
            allSelects.forEach(s => {
                const optionToEnable = s.querySelector(option[value = "${selectedValue}"]);
                if (optionToEnable) {
                    optionToEnable.disabled = false;
                }
            });
        }
        const setupForm = (title, action) => {
            $("#titleForm").text(title)
            $(".modal form").attr("action", action)
        }

        const setFormData = ({
            id_surat,
            nama_surat,
            lampiran,
        }) => {

            $("[name=nama_surat]").val(nama_surat)
            $("[name=file_icon]").val(lampiran)

        }

        function addField() {
            const dynamicFields = document.getElementById("dynamic-fields");
            const formGroup = document.createElement("div");
            formGroup.className = "form-group";
            const countInput = $(dynamicFields).children(".form-group").length
            formGroup.innerHTML = `
            <div class="mt-3">
            <label>Data ${countInput+1}</label>
            <div class="d-flex  ms-3 ">
                 <select name="fields[]" class="form-select" required>
                    <option value="">Pilih Opsi</option>
                    <?php foreach ($data->datalampiran  as $index => $datas) : ?>
                    <option value="<?= $datas->id ?>"><?= $datas->nama_lampiran ?></option>
                    <?php endforeach; ?>
                </select>
                    ${countInput > 0 ? '<button type="button" class="btn btn-danger ms-2" onclick="removeField(this)"><i class="fa-solid fa-trash"></i></button>':""}
                </div></div>
            `;
            dynamicFields.appendChild(formGroup);
        }

        function removeField(button) {
            $(button).parent().parent().remove();
        }

        document.getElementById("add-field").addEventListener("click", addField);

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

                        fetch(`<?= url('/admin/dsurat/') ?>${id}`, {
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