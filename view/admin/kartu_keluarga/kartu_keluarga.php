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
                    <button class="btn btn-success text-white">Import</button>
                    <a href="/admin/kartu-keluarga/create" class="btn btn-warning">Tambah Baru</a>
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
                                            <a href="" title="Edit" class="btn  text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
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
                            <?php if (count($data->data) == 0) : ?>
                                <tr>
                                    <td colspan="7" align="middle">Data kartu keluarga tidak ada</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
</body>

</html>