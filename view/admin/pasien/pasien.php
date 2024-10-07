<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKAMDIS | Pasien</title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1 p-3">
        <?php includeFile("layout/navbar") ?>
        <div class="d-flex align-items-center">
            <div class="">
                <h2 class="mb-0 "><?= $title ?></h2>
                <p class="text-body-secondary "><?= $description ?> </p>
            </div>
            <div class="ms-auto">
                <a href="/admin/pasien/create" class="btn btn-primary">Tambah Pasien</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Nomor telepon</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($datas  as $index => $data) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $data->name ?></td>
                                <td><?= $data->birth_date ?></td>
                                <td><?= $data->phone ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($datas) == 0) : ?>
                            <tr>
                                <td colspan="7" align="middle">Data pasien tidak ada</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
       
    </main>


    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
</body>

</html>
