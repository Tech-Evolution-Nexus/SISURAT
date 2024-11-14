<?php

namespace app\controllers;

use app\services\Database as ServicesDatabase;
use services\Database;
use PDO;
use FileUploader;


class ProfileController
{

    public  function profile()
    {
        return view("admin/setting/profile");
    }

    public function profmin()
    {
        // var_dump(password_hash("admin",PASSWORD_BCRYPT));
        // die();
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hasError = false;
        if (empty($email)) {
            $_SESSION["usernameErr"] = 'email tidak boleh kosong';
            $hasError = true;
        }

        if (empty($password)) {
            $_SESSION["passwordErr"] = 'Kata sandi tidak boleh kosong';
            $hasError = true;
        } else if (strlen($password) < 8) {
            $_SESSION["passwordErr"] = 'Kata sandi minimal 8 karakter';
            $hasError = true;
        }
        if ($hasError) {
            return redirect("admin/profile");
        }
    }
    
    public function uploadPP() {
        $ficon = $_FILES['file_icon'] ?? null;
        $ficonName = $ficon['name'];
        $fileType = strtolower(pathinfo($ficon['name'], PATHINFO_EXTENSION));
        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($fileType, $ficon, "../upload/photoprofile/", $allowedFileTypes);
        $uploadSs = $uploader->isAllowedFileType();
        if ($uploadSs !== true) {
            return redirect()->with("error", "$uploadSs")->back();
        }

        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            return redirect()->with("success", "$uploadStatus")->back();
        }
        return redirect()->with("success", "Data berhasil ditambahkan.")->back();

    }

    // public function photo_profile() {
    //     session_start();
    //     require 'database_connection.php'; // Sambungkan ke database

    //     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    //         $file = $_FILES['profile_picture'];
    //         $targetDir = "uploads/";
    //         $fileName = uniqid() . "-" . basename($file['name']);
    //         $targetFilePath = $targetDir . $fileName;
    //         $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    //         // Memeriksa jenis file
    //         $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
    //         if (in_array(strtolower($fileType), $allowedTypes)) {
    //             if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    //                 // Simpan URL gambar ke database
    //                 $userId = $_SESSION['user_id'];
    //                 $query = "UPDATE users SET profile_picture = ? WHERE id = ?";
    //                 $stmt = $conn->prepare($query);
    //                 $stmt->bind_param("si", $targetFilePath, $userId);
    //                 if ($stmt->execute()) {
    //                     echo json_encode(['success' => true, 'imageUrl' => $targetFilePath]);
    //                     exit;
    //                 }
    //             }
    //         }
    //         echo json_encode(['success' => false]);
    //     }
    // }
}
