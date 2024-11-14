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
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>NIK</th>
                                <th>Email</th>
                                <th>Nomor Telepon</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data->data) && is_array($data->data)) : ?>
                            <?php foreach ($data->data as $index => $user) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $user->nama_lengkap ?></td>
                                    <td><?= $user->nik ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->no_hp?></td>
                                    <td><?= $user->role ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <a href="/admin/users/<?= $user->id ?>/edit" title="Detail" class="btn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <button data-url="<?= url("/admin/users/$user->id") ?>" title="Hapus" class="btn deleteBtn  text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
            
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
    <!--end yang perlu diubah -->

    <?php includeFile("layout/script") ?>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('.data-table').DataTable();

            // handle edit data
            $(".editBtn").on("click", function() {
                const id = $(this).attr("data-id");
                $("#titleForm").text("Ubah Pengguna");
                $(".modal form").attr("action", "/admin/master-user/" + id);
                $(".modal").modal("show");

                $.ajax({
                    url: "/admin/master-user/ajax-user/" + id,
                    dataType: "json", // Pastikan response dalam format JSON
                    success: (data) => {
                        if (data) {
                            $("[name=nama_lengkap]").val(data.nama_lengkap);
                            $("[name=nik]").val(data.nik);
                            $("[name=email]").val(data.email);
                            $("[name=no_hp]").val(data.no_hp);
                            $("[name=role]").val(data.role);
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>