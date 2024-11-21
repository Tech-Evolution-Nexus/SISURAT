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
                    <button type="button" class="btn btn-warning" id="add-btn">
                        Export
                    </button>
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
                                            <button data-id="<?= $kk->nomor_surat ?>" title="Detail" class="btn detailBtn  text-white btn-success btn-sm">
                                                DETAIL
                                            </button>
                                            <a href="<?= url("/admin/surat-selesai/export/" . $kk->id) ?>">
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
                        <div class="row" id="isi">

                        </div>
                        <br><br>

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
                url: "/SISURAT/admin/surat-selesai/" + id,
                success: (data) => {
                    $('#fselect').hide();
                    $('.fselected').remove();

                    const dynamicFields = document.getElementById("isi");

                    // Menambahkan biodata
                    data.biodata.forEach((element, index) => {
                        for (const [key, value] of Object.entries(element)) {
                            const inputField = document.createElement("div");
                            inputField.classList.add("col-6"); // Pastikan tidak ada spasi di sini

                            const label = key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());

                            inputField.innerHTML = `
                                <div class="form-group mt-3 ms-3">
                                    <label>${label}</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="${value}" placeholder="${label}" name="${key}[]" readonly>
                                    </div>
                                </div>
                            `;
                            dynamicFields.appendChild(inputField);
                        }
                    });

                    const suratFieldRow = document.createElement("div");
                    suratFieldRow.classList.add("row", "mt-3", "ms-3");
                    dynamicFields.appendChild(suratFieldRow);

                    data.datasurat.forEach((surat) => {
                        const suratItem = document.createElement("div");
                        suratItem.classList.add("col-6", "form-group", "mt-3");

                        suratItem.innerHTML = `
                <label>${surat.nama_lampiran}</label>
                <div class="input-group">
                    <img src="${surat.url}" alt="${surat.nama_lampiran}" style="width: 100px; height: auto;"/>
                </div>
            `;
                        suratFieldRow.appendChild(suratItem);
                    });
                }
            });

        })
    </script>
</body>

</html>