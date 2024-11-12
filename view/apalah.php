<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
        }

        .header {
            background-color: #112d53;
            padding: 20px;
            text-align: right;
            color: white;
        }

        .profile-container {
            background-color: white;
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }

        .profile-header img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
        }

        .profile-header h2,
        .profile-header p {
            margin: 0;
        }

        .profile-content {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 15px;
        }

        .profile-section {
            flex: 1;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-section input[type="text"],
        .profile-section input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .profile-section button {
            width: 100%;
            padding: 10px;
            background-color: #112d53;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-section button:hover {
            background-color: #0f2448;
        }
    </style>
</head>

<body>

    <div class="header">
        <!-- Profile Picture Icon -->
        <img src="profile-pic.jpg" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
    </div>

    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <img src="profile-photo.jpg" alt="User Photo">
            <div>
                <h2>Muhammad Nor Kholit</h2>
                <p>mnorkholit7@gmail.com</p>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="profile-content">
            <div class="profile-section">
                <h3>Edit Profile</h3>
                <label for="fullName">Nama lengkap</label>
                <input type="text" id="fullName" value="Muhammad Nor Kholit">

                <label for="email">Email</label>
                <input type="text" id="email" value="mnorkholit7@gmail.com">

                <label for="phone">Nomor HP</label>
                <input type="text" id="phone" value="081276889072">

                <label for="password">Kata Sandi</label>
                <input type="password" id="password" placeholder="Masukkan kata sandi anda">

                <button type="button">Simpan</button>
            </div>

            <div class="profile-section">
                <h3>Ubah Kata Sandi</h3>
                <label for="currentPassword">Masukkan kata sandi anda</label>
                <input type="password" id="currentPassword">

                <label for="newPassword">Masukkan kata sandi baru</label>
                <input type="password" id="newPassword">

                <label for="confirmPassword">Konfirmasi kata sandi</label>
                <input type="password" id="confirmPassword">

                <button type="button">Kirim</button>
            </div>
        </div>
    </div>

</body>

</html>