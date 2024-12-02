<?php

namespace app\controllers;


use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;

use Exception;


class AuthController
{
    public $model;
    // private $model;
    public function __construct()
    {
        $this->model = (object)[];
        $this->model->users = new UserModel();
    }
    public  function index()
    {

        return view("auth/login");
    }


    public function authentic()
    {

        //validasi login
        request()->validate([
            "email" => "required|email",
            "password" => "required|min:8",
        ]);
        $email = request("email");
        $password = request("password");


        $user = $this->model->users->where("email", "=", $email)->first();

        if (!$user) {
            return redirect()->with("error", "User tidak ditemukan")->back();
        }

        if ($user->role !== "admin") {
            return redirect()->with("error", "akun Anda tidak memiliki hak akses ke fitur ini.")->back();
        }

        if (!password_verify($password, $user->password)) {
            return redirect()->with("error", "Password salah")->back();
        }

        session()->set("user_id", $user->id);
        return redirect("/admin");
    }



    public function lupaPassword()
    {
        return view("auth/lupapassword");
    }

    public function gantiPassword()
    {
        $token = request("token");
        $model = new UserModel();
        // dd("das");
        if (is_null($token) || !$this->isValidTokenFormat($token) || !$model->where("token_reset", "=", $token)->first()) {
            session()->flash('error', 'Token tidak valid atau telah kadaluarsa.');
        }

        $data = base64_decode($token);
        $datas = json_decode($data);

        if (json_last_error() !== JSON_ERROR_NONE || !isset($datas->email, $datas->token, $datas->exp)) {
            session()->flash('error', 'Token tidak valid.');
        }

        $email = filter_var($datas->email, FILTER_SANITIZE_EMAIL);
        $exp = (int) $datas->exp;

        if (time() > $exp) {
            session()->flash('error', 'Token telah kadaluarsa.');
        }

        if (!$model->where("email", "=", $email)->first()) {
            session()->flash('error', 'Pengguna tidak ditemukan.');
        }

        return view("auth/reset_password", ['token' => $token]);
    }

    private function isValidTokenFormat($token)
    {
        return preg_match('/^[A-Za-z0-9+\/=]+$/', $token);
    }



    public function gantiPasswordStore()
    {
        request()->validate([
            "password" => "required|min:8",
            "confirm_password" => "required|min:8|same:password",
        ], [
            "password.required" => "Password wajib diisi",
            "confirm_password.required" => "Konfirmasi password wajib diisi",
            "password.min" => "Password minimal 8 karakter",
            "confirm_password.min" => "Konfirmasi password  minimal 8 karakter",
            "confirm_password.same" => "Konfirmasi password  tidak sama",
        ]);
        $token = request("token");
        $password = request("password");

        // Encrypt password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        if (!$token) {
            return redirect()->with("error", "Token Tidak Ditemmukan. Silakan coba lagi.")->back();
        }
        $data = [
            "password" => $hashed_password,
            "token_reset" => null
        ];

        $result = $this->model->users->where("token_reset", "=", $token)->first();
        if ($this->model->users->where("id",$result->id)->update($data)) {
            return redirect()->with("success", "Berhasil mengubah password")->to("/login");
        } else {
            return redirect()->with("success", "Gagal mengubah password,Coba lagi")->back();
        }
    }


    public function kirimLinkReset()
    {
        // Tangani pengiriman link reset password
        $email = $_POST['email'];
        // Logika pengiriman email reset password
    }
    public function sendemail()
    {
        $model  = new UserModel();
        $email = $_POST['email'];
        $result = $model->where("email", "=", $email)->first();
        if ($result) {
            // Buat token
            $token = bin2hex(random_bytes(50)); // Generate random token
            $expiry = time() + 3600; // 1 jam ke depan
            $payload = json_encode(['email' => $email, 'token' => $token, 'exp' => $expiry]);
            $encodedToken = base64_encode($payload);
            $data = [
                "token_reset" => $encodedToken,
                "email" => $email
            ];
            // Simpan token dan tanggal kedaluwarsa di database
            $model->update($result->id, $data);

            $resetLink = "http://localhost/SISURAT/ganti-password?token=" . $encodedToken;
            $mail = new PHPMailer(true);
            try {
                // Pengaturan server SMTP
                $mail->isSMTP();
                $mail->Host = $_ENV['MAIL_HOST']; // Ganti dengan server SMTP Anda
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_USERNAME']; // Ganti dengan email Anda
                $mail->Password = $_ENV['MAIL_PASSWORD']; // Ganti dengan password email Anda
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // atau PHPMailer::ENCRYPTION_SMTPS
                $mail->Port = 587; // Ganti dengan port yang sesuai

                // Penerima
                $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $mail->addAddress($email); // Tambahkan alamat email penerima

                // Konten email
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body = "Klik tautan ini untuk reset password Anda:
                    <br><br>
                    <a href='{$resetLink}' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007BFF; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                    ";

                // Kirim email
                $mail->send();
                return redirect()->with("success", "Silahkan cek email untuk melihat pesan")->back();
            } catch (Exception $e) {
                return redirect()->with("error", "Terjadi kesalahan ketika mengirimkan pesan ke email anda")->back();
            }
        }
    }
}
