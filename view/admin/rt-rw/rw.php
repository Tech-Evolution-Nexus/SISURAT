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
                        Tambah RW
                    </button>
                </div>
            </div>


            <!-- FORM MODAL -->
            <div id="modal" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="titleForm">Tambah RW</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/master-rw" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12 search-section mb-4">
                                        <h6 class="mb-2 fw-bold ">Pencarian Data Masyarakat</h6>
                                        <div class="form-group mb-2 ms-3">
                                            <label for="search">Cari Berdasarkan NIK<span class="text-danger">*</span></label>
                                            <select name="search" class="form-control select2-modal" data-placeholder="Masukkan NIK untuk mencari" id="">
                                                <option value=""></option>
                                                <?php foreach ($data->masyarakat as $masyarakat): ?>
                                                    <option value="<?= $masyarakat->id ?>"><?= $masyarakat->nama_lengkap ?> | <?= $masyarakat->nik ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-12 row personal-information" style="transition: all .5s;">
                                        <h6 class="mb-2  fw-bold">Detail Informasi Masyarakat</h6>
                                        <input type="hidden" name="id_masyarakat">
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="nik">Nomor Induk Kependudukan (NIK)</label>
                                                <input readonly type="text" class=" bg-body-secondary form-control" placeholder="Nomor Induk Kependudukan" name="nik" id="nik" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="nama_lengkap">Nama Lengkap</label>
                                                <input readonly type="text" class=" bg-body-secondary form-control" placeholder="Nama Lengkap" name="nama_lengkap" id="nama_lengkap" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="alamat">Alamat</label>
                                                <input readonly type="text" class=" bg-body-secondary form-control" placeholder="Alamat Lengkap" name="alamat" id="alamat" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="rt">RT</label>
                                                <input readonly type="text" class=" bg-body-secondary form-control" placeholder="Nomor RT" name="rt" id="rt" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label for="rw">RW</label>
                                                <input readonly type="text" class=" bg-body-secondary form-control" placeholder="Nomor RW" name="rw" id="rw" required>

                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="no_hp">Nomor Telepon<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control phone-format" placeholder="Contoh: 08123456789" name="no_hp" id="no_hp" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3 position-relative">
                                                <label for="password">Kata Sandi<span class="text-danger required-password">*</span></label>
                                                <input type="password" class="form-control password" placeholder="Masukkan kata sandi" name="password" id="password" required>
                                                <span class="toggle-password position-absolute" style="right: 10px; top: 50%; cursor: pointer;">
                                                    <i class="fa fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama RW</th>
                                <th>Ketua RW</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->nik ?></td>
                                    <td><?= $kk->nama_lengkap ?></td>
                                    <td><?= $kk->rw ?></td>
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
        // handle change data
        $('.select2-modal').on('select2:select', function(e) {
            var data = e.params.data;
            $(".personal-information,.modal-footer").css({
                height: "auto",
                opacity: 1
            })


            $.ajax({
                url: "/admin/master-rw/ajax-masyarakat/" + data.id,
                success: (data) => {
                    const formData = data;
                    console.log(formData)
                    setFormData(formData)

                }
            })
        });

        // default style
        $(".personal-information, .modal-footer").css({
            height: 0,
            opacity: 0
        })

        // handle add data
        $("#add-btn").on("click", function() {
            setupForm("Tambah RW", "/admin/master-rw")
            $(".search-section").show();
            $(".required-password").show();
            $("[name=password]").attr('required');
            $(".modal form").trigger("reset");
            $(".personal-information, .modal-footer").css({
                height: 0,
                opacity: 0
            })
        })

        // handle edit data
        $(".editBtn").on("click", function() {
            const id = $(this).attr("data-id")

            setupForm("Ubah RW", "/admin/master-rw/" + id)
            $(".search-section").hide();
            $(".required-password").hide();
            $("[name=password]").removeAttr('required');
            $(".personal-information,.modal-footer").css({
                height: "auto",
                opacity: 1
            })

            $(".modal").modal("show")
            $.ajax({
                url: "/admin/master-rw/ajax-rw/" + id,
                success: (data) => {
                    const formData = data;
                    console.log(formData);

                    setFormData(formData)
                }
            })
        })


        const setupForm = (title, action) => {
            $("#titleForm").text(title)
            $(".modal form").attr("action", action)
        }

        const setFormData = ({
            nik,
            nama_lengkap,
            alamat,
            rt,
            rw,
            no_hp,
            id
        }) => {

            $("[name=id_masyarakat]").val(id)
            $("[name=nik]").val(nik)
            $("[name=nama_lengkap]").val(nama_lengkap)
            $("[name=alamat]").val(alamat)
            $("[name=rt]").val(rt)
            $("[name=rw]").val(rw)
            $("[name=no_hp]").val(no_hp)
        }
    </script>
</body>

</html>