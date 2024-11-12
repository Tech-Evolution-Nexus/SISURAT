<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="<?= assets("assets/logobadean.png") ?>" type="image/x-icon">
    <title>SISURAT | <?= $data->title ?></title>
    <?php includeFile("layout/css") ?>
</head>

<body class="admin d-flex">
    <div class="header-layer bg-primary"></div>
    <?php includeFile("layout/sidebar") ?>
    <!--start yang perlu diubah -->
    <main class="flex-grow-1">
        <?php includeFile("layout/navbar") ?>
        <div class="p-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card">
                        <form action="edit_profile.php" method="post" autocomplete="on" id="form2" class="p-2">
                            <div class="d-flex">
                                <div class="position-relative">
                                    <img class="rounded-circle bg-dark d-flex" src="<?= assets("assets/logo-admin.png") ?>" alt="Profile Picture" style="width: 150px;  height: 150px;  margin: 10px;">
                                    <!-- <button class="btn btn-secondary btn-sm mt-2" type="submit" style="border-radius: 10; width: 140px; height: 30px;">Ubah Foto</button> -->
                                    <button class="btn btn-secondary btn-sm position-absolute edit-button" type="button" aria-label="Edit Foto">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h5 class="m-0 fw-bold"><br>Nama_lengkap<br></h5>
                                    <span>E-mail</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row p-4">
                                <div class="col-md-6 col-10">
                                    <label class="mt-2 form-label" for="fullname">Nama Lengkap</label>
                                    <input type="text" id="email" name="email" class="form-control" disabled>
                                </div>
                                <div class="col-md-6 col-10">
                                    <label class="mt-2 form-label" for="E-mail">NIK</label>
                                    <input type="text" id="email" name="email" class="form-control" disabled>
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