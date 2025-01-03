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
                    <a href="<?= url("/admin/export-excelsurat-selesai") ?>" class="btn btn-warning">
                        Export
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-body ">
                    <table class="table data-table ">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NOMOR SURAT</th>
                                <th>NAMA</th>
                                <th>JENIS SURAT</th>
                                <th>WAKTU PENGAJUAN</th>
                                <th>STATUS</th>

                                <th>AKSI</th>


                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data->data  as $index => $kk) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $kk->nomor_surat ?></td>
                                    <td><?= $kk->nama_lengkap ?></td>
                                    <td><?= $kk->nama_surat ?></td>
                                    <td><?= formatDate($kk->created_at) ?></td>
                                    <td><?= formatStatusPengajuan($kk->status) ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <button data-id="<?= $kk->id ?>" title="Detail" class="btn detailBtn  text-white btn-success btn-sm">
                                                Detail
                                            </button>
                                            <a class="btn btn-primary btn-sm" href="<?= url("/admin/surat-selesai/export/" . $kk->id) ?>">
                                                Download
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
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="titleForm">Detail Surat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <!-- <h5>Detail Informasi Surat</h5> -->
                            <div class="row ms-2">
                                <div class="col-md-3 col-12">
                                    <p class="mb-1">Nomor Surat</p>
                                </div>
                                <div class="col-md-9 col-12 d-flex gap-2 align-items-center">
                                    <h6 class="fw-bold" id="nosurat">: </h6>
                                    <!-- <h6 class="fw-bold" id="no_surat">
                                        /
                                    </h6>
                                    <h6 class="fw-bold" id="kdtambabhankelurahan"> </h6> -->
                                </div>
                                <div class="col-md-3 col-12">
                                    <p class="mb-1">Kode Kelurahan</p>
                                </div>
                                <div class="col-md-9 col-12">
                                    <h6 class="fw-bold" id="kdkelurahan">: </h6>
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

                                <div class="row col-12 " id="fields">

                                </div>
                                <h5 class="mt-3">Dokumen Pendukung</h5>


                                <div class="row col-12 " id="dokument_pendukung">

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </main>
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
    <script>
        $(".detailBtn").on("click", function() {
            const id = $(this).attr("data-id")
            console.log(id);
            $(".modal").modal("show")
            $.ajax({
                url: "<?= url("admin/surat-selesai/detail/") ?>" + id,
                success: (data) => {
                    $('#fselect').hide();
                    $('.fselected').remove();
                    setFormData(data)
                }
            });

        })


        const setFormData = (data) => {
            $("#nosurat").text(`:${data.nomor_surat ?? "-"}`)
            // $("#kdtambabhankelurahan").text(`:${data.nomor_surat_tambahan ?? "-"}`)
            $("#kdkelurahan").text(`:${data.kode_kelurahan ?? "-"}`)
            $("#nik").text(`:${data.nik ?? "-"}`)
            $("#nama").text(`:${data.nama_lengkap ?? "-"}`)
            $("#tempat_tanggal_lahir").text(`:${data.tempat_lahir ?? "-"} / ${data.tgl_lahir ?? "-"}`)
            $("#jk").text(`:${data.jenis_kelamin ?? "-"}`)
            $("#kebangsaan_agama").text(`:${data.kewarganegaraan ?? "-"} / ${data.agama ?? "-"}`)
            $("#status").text(`:${data.status  ?? "-"}`)
            $("#pekerjaan").text(`:${data.pekerjaan ?? "-"}`)
            $("#alamat").text(`:${data.alamat ?? "-"}`)
            $("#tanggal_pengajuan").text(`:${data.tanggal_pengajuan ?? "-"}`)


            let html = "";
            data?.lampiran?.forEach(lampiran => {
                $("#dokument_pendukung").empty();
                html += `
                <div class="col-md-3 col-12 ">
                    <p>${lampiran.nama_lampiran}</p>
                </div>
                    <div class="col-md-9 col-12 mb-4">
                    <img id="${lampiran.nama_lampiran}" src="<?= url("/admin/assetsmasyarakat") ?>/${lampiran.url}" class="img-thumbnail" alt="${lampiran.nama_lampiran}">
                </div>`;
            });
            $("#dokument_pendukung").append(html);
            html = "";
            data?.fields?.forEach(field => {
                $("#fields").empty();
                html += `
                <div class="col-md-3 col-12 ">
                    <p>${field.nama_field}</p>
                </div>
                    <div class="col-md-9 col-12 mb-4">
                                            <h6 class="fw-bold" >:${field.value} </h6>
                    
                </div>`;
            });


            $("#fields").append(html);
        }
    </script>
</body>

</html>