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
                                                    <option value="<?= $masyarakat->nik ?>"><?= $masyarakat->nama_lengkap ?> | <?= $masyarakat->nik ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-12 row personal-information" style="transition: all .5s;">
                                        <h6 id="title" class="mb-2  fw-bold">Detail Informasi Masyarakat</h6>
                                        <p id="description"></p>
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
                                        <h6 class="mb-2  fw-bold mt-4">Masa Jabatan</h6>

                                        <div class="col-md-6 col-12 ">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="masa_jabatan_awal">Masa Jabatan Awal</label>
                                                <input type="date" class="  form-control" name="masa_jabatan_awal" id="masa_jabatan_awal" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label for="masa_jabatan_akhir">Masa Jabatan Akhir</label>
                                                <input type="date" class="  form-control" name="masa_jabatan_akhir" id="masa_jabatan_akhir" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary fw-normal">Simpan</button>
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
                                <th>Tanggal Jabatan</th>
                                <th>Status</th>
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
                                    <td><?= formatDate($kk->masa_jabatan_awal, true) ?> - <?= formatDate($kk->masa_jabatan_akhir, true) ?></td>
                                    <td> <button data-nik="<?= $kk->nik ?>" title="Ubah Status" class="btn statusBtn text-white btn-warning btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </button></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <button data-nik="<?= $kk->nik ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </button>


                                            <a href="<?= url("/admin/master-rw/$kk->rw/master-rt") ?>" title="Detail" class="btn  text-white btn-success btn-sm">
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
                url: "<?= url("/admin/master-rw/ajax-masyarakat/") ?>" + data.id,
                success: (data) => {
                    setFormData(data)
                },
                error: (error) => {
                    console.log(error);

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
            setupForm("Tambah RW", '<?= url("/admin/master-rw/") ?>')
            $(".search-section").show();
            $("form [type=submit]").text("Simpan").removeClass("btn-danger").addClass("btn-primary");

            $("form").find("input,label,h6:not(#title)").show()
            $("#title").text(`Detail Informasi Masyarakat`);
            $("#description").text("");
            $(".required-password").show();
            $("[name=password]").attr('required');
            $(".modal form").trigger("reset");
            $(".personal-information, .modal-footer").css({
                height: 0,
                opacity: 0
            })
        })

        // handle edit data
        $(".statusBtn").on("click", function() {
            const nik = $(this).attr("data-nik")
            $("form").find("input,label,h6:not(#title)").hide()
            $("form [type=submit]").text("Nonaktif").removeClass("btn-primary").addClass("btn-danger text-white");
            setupForm("Ubah Status Ketua Rw", '<?= url("/admin/master-rw/") ?>' + nik)
            $(".search-section").hide();
            $(".required-password").hide();
            $("[name=password]").removeAttr('required');
            $(".personal-information,.modal-footer").css({
                height: "auto",
                opacity: 1
            })

            $(".modal").modal("show")
            $.ajax({
                url: '<?= url("/admin/master-rw/ajax-rw/") ?>' + nik,
                success: (data) => {
                    $("#title").text(`Apakah anda yakin merubah status ketua RW ${data.nama_lengkap} menjadi Nonaktif ?`);
                    $("#description").text(`Tindakan ini akan mengubah status ketua rw menjadi masyarakat`);
                    setFormData(data)
                }
            })
        })
        // handle edit data
        $(".editBtn").on("click", function() {
            const nik = $(this).attr("data-nik")
            $("form").find("input,label,h6:not(#title)").show()
            $("#title").text(`Detail Informasi Masyarakat`);
            $("#description").text("");
            $("form [type=submit]").text("Simpan").removeClass("btn-danger").addClass("btn-primary");

            setupForm("Ubah  Rw", '<?= url("/admin/master-rw/") ?>' + nik)
            $(".search-section").hide();
            $(".required-password").hide();
            $("[name=password]").removeAttr('required');
            $(".personal-information,.modal-footer").css({
                height: "auto",
                opacity: 1
            })

            $(".modal").modal("show")
            $.ajax({
                url: '<?= url("/admin/master-rw/ajax-rw/") ?>' + nik,
                success: (data) => {

                    setFormData(data)
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
            id,
            masa_jabatan_akhir,
            masa_jabatan_awal
        }) => {


            $("[name=nik]").val(nik)
            $("[name=nama_lengkap]").val(nama_lengkap)
            $("[name=alamat]").val(alamat)
            $("[name=rt]").val(rt)
            $("[name=rw]").val(rw)
            $("[name=no_hp]").val(no_hp)
            masa_jabatan_akhir = masa_jabatan_akhir.split(' ')[0]; // '2024-11-30'
            masa_jabatan_awal = masa_jabatan_awal.split(' ')[0];
            $("[name=masa_jabatan_akhir]").val(masa_jabatan_akhir)
            $("[name=masa_jabatan_awal]").val(masa_jabatan_awal)
        }
    </script>
</body>

</html>