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
                        <form action="<?= url("admin/profile") ?>" method="post" autocomplete="on" id="form2" class="p-2">
                            <div class="d-flex">
                                <div style="width: 150px; height: 150px;" class="me-4">
                                    <img class="rounded-circle bg-dark d-flex" src="<?= assets("assets/profile/" . auth()->user()->foto_profile) ?>" alt="Profile Picture" id="profile-picture" style="width: 100%; height: 100%; object-fit:cover; margin: 10px;">
                                    <button class="edit-button btn btn-secondary btn-sm position-absolute" type="button" aria-label="Edit Foto" onclick="document.getElementById('file-input').click();">
                                        <i class="fas fa-camera"></i>
                                    </button>
                                    <input type="file" id="file-input" accept="image/*" style="display: none;" onchange="uploadProfilePicture()">
                                    <script>
                                        function uploadProfilePicture() {
                                            const fileInput = document.getElementById('file-input');
                                            const file = fileInput.files[0];
                                            document.querySelector("#profile-picture").src = URL.createObjectURL(file);
                                            document.querySelector(".profil-img-small").src = URL.createObjectURL(file);
                                            if (!file) return;

                                            const formData = new FormData();
                                            formData.append('profile_picture', file);

                                            // Ganti URL ini dengan endpoint server Anda yang menangani pengunggahan gambar
                                            fetch('<?= url("/upload-profile-picture") ?>', {
                                                    method: 'POST',
                                                    body: formData,
                                                })
                                                .then(response => response.json())
                                                .then(data => {
                                                    if (data.success) {
                                                        // Perbarui tampilan gambar profil di halaman
                                                        alert('Foto profil berhasil diperbarui');
                                                    } else {
                                                        alert('Gagal memperbarui foto profil');
                                                    }
                                                })
                                                .catch(error => {
                                                    console.log('Error:', error);
                                                    alert('Terjadi kesalahan saat mengunggah foto');
                                                    window.location
                                                });
                                        }
                                    </script>
                                </div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h5 class="m-0 fw-bold"><br><?= auth()->user()->nama_lengkap ?><br></h5>
                                    <span><?= auth()->user()->email ?></span>
                                    <span class="only-number"><?= auth()->user()->no_hp ?></span>
                                </div>
                            </div>
                            <hr class="my-custom-class">
                            <div class="row p-4">
                                <div class="col-md-6 col-5 fs-6">
                                    <label class="form-label" for="fullname">Nama Lengkap</label>
                                    <input type="text" id="fullname" name="fullame" class="form-control" value="<?= auth()->user()->nama_lengkap ?>" disabled>
                                </div>
                                <div class="col-md-6 col-5">
                                    <label class="form-label" for="E-mail">Nomor Induk Kependudukan</label>
                                    <input type="text" id="nik" name="nik" class="form-control" value="<?= auth()->user()->nik ?>" disabled>
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
                                <input value="<?= auth()->user()->email ?>" type="text" id="email" name="email" class="form-control bg-secondary" placeholder="email@gmail.com" maxlength="20" autocomplete="off" aria-describedby="emailHelp" />
                                <div id="emailHelp" class="form-text">Kami tidak akan membagikan E-mail anda pada siapapun.</div>
                                <label class="form-label d-block mt-3" for="email">No HP</label>
                                <input value="<?= auth()->user()->no_hp ?>" type="text" id="nohp" name="nohp" class="form-control   only-number bg-secondary" placeholder="08xxxxxxxxxx" maxlength="13" autocomplete="off" />
                                <label class="form-label d-block mt-3" for="email">Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control   bg-secondary" placeholder="Masukkan kata sandi anda" maxlength="50" autocomplete="off" />
                                    <button type="button" class="bg-transparent password-toggle border-0 position-absolute " style="top:50%;right:10px;transform:translateY(-50%)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
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
                                    <input type="password" id="password" name="password" class="form-control   bg-secondary" placeholder="Masukkan kata sandi anda saat ini" maxlength="50" autocomplete="off" required />
                                    <button type="button" class="bg-transparent password-toggle border-0 position-absolute " style="top:50%;right:10px;transform:translateY(-50%)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <label class="d-block mt-3 form-label" for="newpass">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" id="newpass" name="newpass" class="form-control   bg-secondary" placeholder="Masukkan kata sandi baru" maxlength="50" autocomplete="off" required />
                                    <button type="button" class="bg-transparent password-toggle border-0 position-absolute " style="top:50%;right:10px;transform:translateY(-50%)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <label class="d-block mt-3 form-label" for="confirmpass">Konfirmasi Kata Sandi</label>
                                <div class="input-group">
                                    <input type="password" id="newpass" name="confirmpass" class="form-control   bg-secondary" placeholder="Konfirmasi kata sandi" maxlength="50" autocomplete="off" required />
                                    <button type="button" class="bg-transparent password-toggle border-0 position-absolute " style="top:50%;right:10px;transform:translateY(-50%)">
                                        <i class="fa fa-eye"></i>
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

</body>

</html>