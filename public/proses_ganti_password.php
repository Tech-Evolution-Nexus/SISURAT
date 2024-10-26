<?php
session_start();
require_once '../config.php'; // Pastikan konfigurasi database sudah benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    // Validasi password dan konfirmasi password
    if (empty($password)) {
        $_SESSION["passwordErr"] = "Password baru tidak boleh kosong.";
        header("Location: reset_password.php");
        exit();
    } elseif ($password !== $confirm_password) {
        $_SESSION["confirmPasswordErr"] = "Konfirmasi password tidak cocok.";
        header("Location: reset_password.php");
        exit();
    } else {
        // Encrypt password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Ambil email pengguna dari session atau URL reset token
        $email = $_SESSION["reset_email"]; // Misalnya, email disimpan di session

        // Update password ke database
        $sql = "UPDATE users SET password = ? WHERE email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $hashed_password, $email);
            if ($stmt->execute()) {
                // Password berhasil diubah
                $_SESSION["success"] = "Password berhasil diubah.";
                header("Location: login.php");
                exit();
            } else {
                // Jika terjadi kesalahan saat update
                $_SESSION["error"] = "Terjadi kesalahan, coba lagi.";
                header("Location: reset_password.php");
                exit();
            }
        }
        $stmt->close();
    }
}
?>
