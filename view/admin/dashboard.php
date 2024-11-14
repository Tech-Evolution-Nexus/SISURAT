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
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h1>20</h1>
                            <h6>Jenis Surat</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>





    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>

</body>

</html>