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

            </div>


            <div class="card">
                <div class="card-body ">
                    <div class="table-responsive">

                        <table class="table data-table ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Jenis Surat</th>
                                    <th>Waktu Pengajuan</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody> <?php foreach ($data->data  as $index => $kk) : ?> <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $kk->nik ?></td>
                                        <td><?= $kk->nama_lengkap ?></td>
                                        <td><?= $kk->nama_surat ?></td>
                                        <td><?= formatDate($kk->created_at) ?></td>
                                        <td><?= formatStatusPengajuan($kk->status) ?></td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Action buttons">
                                                <button data-id="<?= $kk->id ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr> <?php endforeach; ?> </tbody>
                        </table>
                    </div>

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
                                <div class="card-body">
                                    <!-- <h5>Detail Informasi Surat</h5> -->
                                    <div class="row ms-2">
                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Nomor Surat</p>
                                        </div>
                                        <div class="col-md-9 col-12 d-flex">
                                            <h6 class="fw-bold" id="no_surat">: / </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Kode Kecamatan</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="kode_kecamatan">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">NIK</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="nik">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Nama</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="nama">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Tempat, Tanggal Lahir</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="tempat_tanggal_lahir">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Jenis Kelamin</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="jk">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Kebangsaan/Agama</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="kebangsaan_agama">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Status</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="status">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Pekerjaan</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="pekerjaan">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Alamat</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="alamat">: </h6>
                                        </div>

                                        <div class="col-md-3 col-12">
                                            <p class="mb-1">Tanggal Pengajuan</p>
                                        </div>
                                        <div class="col-md-9 col-12">
                                            <h6 class="fw-bold" id="tanggal_pengajuan">: </h6>
                                        </div>

                                        <h5 class="mt-3">Dokumen Pendukung</h5>

                                        <div class="row col-12 " id="dokument_pendukung">
                                            <div class="col-md-3 col-12">
                                                <p class="mb-1">Bukti Pendukung</p>
                                            </div>
                                            <div class="col-md-9 col-12">
                                                <img id="bukti_pendukung" src="" class="img-thumbnail" alt="Bukti Pendukung">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary fw-normal">Terima</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        // handle edit data
        $(".editBtn").on("click", function() {
            const id = $(this).attr("data-id")
            setupForm("Detail Pengajuan Surat", "/admin/surat-masuk")

            $(".modal").modal("show")
            $.ajax({
                url: "/admin/surat-masuk/ajax/" + id,
                success: (data) => {
                    console.log(data);

                    setFormData(data)
                },
                error: (error) => {
                    console.log(error);
                }
            })
        })


        const setupForm = (title, action) => {
            $("#titleForm").text(title)
            $(".modal form").attr("action", action)
        }

        const setFormData = (data) => {

            $("#no_surat").text(`${data.nomor_surat ?? "-"} / ${data.nomor_surat_tambahan ?? "-"}`)
            $("#kode_kecamatan").text(`${data.kode_kelurahan ?? "-"}`)
            $("#nik").text(`${data.nik ?? "-"}`)
            $("#nama").text(`${data.nama_lengkap ?? "-"}`)
            $("#tempat_tanggal_lahir").text(`${data.tempat_lahir ?? "-"} / ${data.tgl_lahir ?? "-"}`)
            $("#jk").text(`${data.jenis_kelamin ?? "-"}`)
            $("#kebangsaan_agama").text(`${data.kewarganegaraan ?? "-"} / ${data.agama ?? "-"}`)
            $("#status").text(`${data.status  ?? "-"}`)
            $("#pekerjaan").text(`${data.pekerjaan ?? "-"}`)
            $("#alamat").text(`${data.alamat ?? "-"}`)
            $("#tanggal_pengajuan").text(`${data.tanggal_pengajuan ?? "-"}`)

            let html = "";
            data.lampiran.forEach(lampiran => {
                $("#dokument_pendukung").empty();

                html += `
                <div class="col-md-3 col-12 ">
                    <p>${lampiran.nama_lampiran}</p>
                </div>
                    <div class="col-md-9 col-12 mb-4">
                    <img id="${lampiran.nama_lampiran}" src="${lampiran.url}" class="img-thumbnail" alt="${lampiran.nama_lampiran}">
                </div>`;
            });
            $("#dokument_pendukung").append(html);
        }
    </script>
</body>

</html>