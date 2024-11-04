<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISURAT | <?=$data->title ?></title>
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
                        Tambah Pengguna
                    </button>
                </div>
            </div>

            <!-- FORM MODAL -->
            <div id="modal" class="modal hide fade " role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="titleForm">Tambah Pengguna</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/admin/master-user" method="post">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-2 ms-3">
                                            <label for="email">Email<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" placeholder="Masukkan Email" name="email" id="email" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-2 ms-3">
                                            <label for="no_hp">Nomor Telepon<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control phone-format" placeholder="Contoh: 08123456789" name="no_hp" id="no_hp" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group mb-2 ms-3">
                                            <label for="role">Role<span class="text-danger">*</span></label>
                                            <select name="role" class="form-control" id="role" required>
                                                <option value="">Pilih Role</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
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
                    <table class="table data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nomor Telepon</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($data->users) && is_array($data->users)) : ?>
                            <?php foreach ($data->users as $index => $user) : ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->no_hp ?></td>
                                    <td><?= $user->role ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Action buttons">
                                            <button data-id="<?= $user->id ?>" title="Edit" class="btn editBtn text-white btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <a href="/admin/master-user/delete/<?= $user->id ?>" title="Hapus" class="btn text-white btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <a href="/admin/master-user/detail/<?= $user->id ?>" title="Detail" class="btn text-white btn-success btn-sm">
                                                <i class="fa fa-users"></i>
                                            </a>
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

            // handle add data
            $("#add-btn").on("click", function() {
                $("#titleForm").text("Tambah Pengguna");
                $(".modal form").attr("action", "/admin/master-user");
                $(".modal form").trigger("reset");
            });

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
