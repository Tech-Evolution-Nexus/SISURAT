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
                        Tambah KK
                    </button>
                </div>
            </div>


            <!-- FORM MODAL -->
            <div id="modal" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="titleForm">Tambah KK</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/master-rw" method="post">
                            <div class="modal-body">
                                <div class="row">

                                    <div class="col-12 row personal-information" style="transition: all .5s;">
                                        <h6 class="mb-2  fw-bold">Informasi Kartu Keluarga</h6>
                                        <input type="hidden" name="id_masyarakat">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="no_kk">Nomor Kartu Keluarga<span class="text-danger required-password">*</span></label>
                                                <input type="text" class="  form-control" placeholder="Nomor Kartu Keluarga" name="no_kk" id="no_kk" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-2">
                                            <div class="form-group mb-2 ">
                                                <label for="tanggal_kk">Tanggal KK<span class="text-danger required-password">*</span></label>
                                                <input type="date" class="  form-control" placeholder="tanggal_kk" name="tanggal_kk" id="tanggal_kk" required>
                                            </div>
                                        </div>
                                        <h6 class="mb-2  fw-bold">Informasi Kepala Keluarga</h6>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="no_kk">NIK Kepala Keluarga<span class="text-danger required-password">*</span></label>
                                                <input type="text" class="  form-control" placeholder="NIK Kepala Keluarga" name="nik" id="nik" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="nama_lengkap">Nama Lengkap<span class="text-danger required-password">*</span></label>
                                                <input type="text" class="  form-control" placeholder="Nama Lengkap" name="nama_lengkap" id="nama_lengkap" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="alamat">Alamat<span class="text-danger required-password">*</span></label>
                                                <input type="text" class="  form-control" placeholder="Alamat Lengkap" name="alamat" id="alamat" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="rt">RT<span class="text-danger required-password">*</span></label>
                                                <input type="text" class="  form-control" placeholder="Nomor RT" name="rt" id="rt" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2">
                                                <label for="rw">RW<span class="text-danger required-password">*</span></label>
                                                <input type="text" class="  form-control" placeholder="Nomor RW" name="rw" id="rw" required>
                                            </div>
                                        </div>
                                        <h6 class="mb-2  fw-bold">Informasi Wilayah</h6>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="kelurahan">Kelurahan</label>
                                                <input disabled type="text" class="  form-control" placeholder="Kelurahan" name="kelurahan" id="kelurahan" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ">
                                                <label for="kode_pos">Kode Pos</label>
                                                <input disabled type="text" class="  form-control" placeholder="kode_pos" name="kode_pos" id="kode_pos" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="kabupaten">Kabupaten</label>
                                                <input disabled type="text" class="  form-control" placeholder="kabupaten" name="kabupaten" id="kabupaten" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ">
                                                <label for="kecamatan">Kecamatan</label>
                                                <input disabled type="text" class="  form-control" placeholder="kecamatan" name="kecamatan" id="kecamatan" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-2 ms-3">
                                                <label for="provinsi">Provinsi</label>
                                                <input disabled type="text" class="  form-control" placeholder="provinsi" name="provinsi" id="provinsi" required>
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
                                <th>No KK</th>
                                <th>Nama Lengkap</th>
                                <th>Alamat</th>
                                <th>RW</th>
                                <th>RT</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->no_kk ?></td>
                                    <td><?= $kk->nama_lengkap ?></td>
                                    <td><?= $kk->alamat ?></td>
                                    <td><?= $kk->rw ?></td>
                                    <td><?= $kk->rt ?></td>
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

                    setFormData(formData)

                }
            })
        });


        // handle add data
        $("#add-btn").on("click", function() {
            setupForm("Tambah KK", "/admin/kartu-keluarga")
            $(".search-section").show();
            $(".required-password").show();
            $("[name=password]").attr('required');
            $(".modal form").trigger("reset");

        })

        // handle edit data
        $(".editBtn").on("click", function() {
            const id = $(this).attr("data-id")

            setupForm("Ubah RKKW", "/admin/kartu-keluarga/" + id)
            $(".search-section").hide();
            $(".required-password").hide();
            $("[name=password]").removeAttr('required');


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