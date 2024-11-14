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
                                <div class="profile-container position-relative d-flex flex-column align-items-end">
                                    <img class="rounded-circle bg-dark d-flex" src="<?= assets("assets/logo-admin.png") ?>" alt="Profile Picture" style="width: 150px;  height: 150px;  margin: 10px;">
                                    <!-- <button class="btn btn-secondary btn-sm mt-2" type="submit" style="border-radius: 10; width: 140px; height: 30px;">Ubah Foto</button> -->
                                    <button class="btn btn-secondary btn-sm position-absolute edit-button" type="button" aria-label="Edit Foto">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h5 class="m-0 fw-bold"><br>Nama_lengkap<br></h5>
                                    <span>E-mail</span>
                                    <span class="only-number">080808008</span>
                                </div>
                            </div>
                            <hr>
                            <div class="row p-4">
                                <div class="col-md-6 col-5 fs-6">
                                    <label class="form-label" for="fullname">Nama Lengkap</label>
                                    <input type="text" id="fullname" name="fullame" class="form-control form-control-sm" disabled>
                                </div>
                                <div class="col-md-6 col-5">
                                    <label class="form-label" for="E-mail">Nomor Induk Kependudukan</label>
                                    <input type="text" id="nik" name="nik" class="form-control form-control-sm" disabled>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <div class="col-12 fs-6">
                            <form action="edit_profile.php" method="post" autocomplete="on" id="form2">
                                <h4 class="m-0 fw-bold">Edit Profile</h4>
                                <span class="d-block mb-3">Tekan tombol "Simpan" untuk menyimpan perubahan.</span>
                                <label class="form-label" for="email">E-mail</label>
                                <input type="text" id="email" name="email" class="form-control form-control-sm bg-secondary" placeholder="email@gmail.com" maxlength="20" autocomplete="off" aria-describedby="emailHelp" disabled />
                                <div id="emailHelp" class="form-text">Kami tidak akan membagikan E-mail anda pada siapapun.</div>
                                <label class="form-label d-block mt-3" for="email">No HP</label>
                                <input type="text" id="nohp" name="nohp" class="form-control form-control-sm only-number bg-secondary" placeholder="08xxxxxxxxxx" maxlength="13" autocomplete="off" disabled />
                                <label class="form-label d-block mt-3" for="email">Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control form-control-sm bg-secondary" placeholder="Masukkan kata sandi anda" maxlength="50" autocomplete="off" disabled />
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <!-- <script>
                                    $(document).ready(function() {
                                        $('#togglePassword').on('click', function() {
                                            const passwordField = $('#password');
                                            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                                            passwordField.attr('type', type);

                                            // ganti ikon mata
                                            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
                                        });
                                    }); -->
                                </script>
                                <div class="d-flex justify-content-end mt-4">
                                    <button class="btn btn-primary w-30" type="submit">Simpan</button>
                                    <button class="btn btn-secondary w-30 ms-3 fw-bold" type="reset">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-3">
                        <div class="col-12 fs-6">
                            <form action="edit_profile.php" method="post" autocomplete="on" id="form3">
                                <h4 class="m-0 fw-bold">Ubah Kata Sandi</h4>
                                <span class="d-block mb-3">Tekan tombol "Kirim" untuk mengubah Kata Sandi.</span>
                                <label class="d-block md-1 form-label" for="password">Kata Sandi Anda</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control form-control-sm bg-secondary" placeholder="Masukkan kata sandi anda saat ini" maxlength="50" autocomplete="off" required />
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <label class="d-block mt-3 form-label" for="newpass">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" id="newpass" name="newpass" class="form-control form-control-sm bg-secondary" placeholder="Masukkan kata sandi baru" maxlength="50" autocomplete="off" required />
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <label class="d-block mt-3 form-label" for="confirmpass">Konfirmasi Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" id="newpass" name="confirmpass" class="form-control form-control-sm bg-secondary" placeholder="Konfirmasi kata sandi" maxlength="50" autocomplete="off" required />
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <button class="btn btn-primary w-30" type="submit">Kirim</button>
                                </div>
                            </form>
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