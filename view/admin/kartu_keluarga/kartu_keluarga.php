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
                    <a href="/admin/kartu-keluarga/create" class="btn btn-warning">
                        Tambah KK
                    </a>
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
                                            <a href="/admin/kartu-keluarga/<?= $kk->id ?>/edit" title="Edit" class="btn  text-white btn-warning btn-sm">
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