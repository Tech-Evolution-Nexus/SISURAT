<?php

namespace app\controllers;

use app\services\Database;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;
use Exception;

class AuthController
{
    public  function index()
    {
        return view("auth/login");
    }

    public function authentic()
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
            return redirect("/login");
        }


        //Cek inputan ke database
        $user = "SELECT * FROM users where email = '$email'";
        $conn = (new Database())->getConnection();
        $result = $conn->prepare($user);
        $result->execute();
        //var_dump ($result->fetch());
        // die ();
        if ($result->rowCount() > 0) {
            $data = $result->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $data['password'])) {
                return redirect("/admin");
            } else {

                $_SESSION["passwordErr"] = 'Password salah';
                $hasError = true;
                return redirect("/login");

                //die();

            }
        } else { //kondisi jika E-mail tidak terdaftar
            $_SESSION["usernameErr"] = 'Username tidak terdaftar';
            return redirect("/login");

        }

        // if (!$hasError) {
        //     // Login logic here      
        // } else {
        //     return redirect("/login");
        // }
    }

    public function lupaPassword()
    {
        return view("auth/lupapassword");
    }

    public function gantiPassword($token = null)
    {
        $model = new UserModel();
        
        // Check if the token is provided and is valid format
        if (is_null($token) || !$this->isValidTokenFormat($token) || !$model->where("token_reset","=",$token)->first()) {
            // Flash message for invalid token
            session()->set('error', 'Token tidak valid atau telah kadaluarsa.');
            return redirect("/login");
        }
    
        // Decode the token and extract user details safely
        $data = base64_decode($token);
        $datas = json_decode($data);
    
        // Ensure that decoding was successful and user exists
        if (json_last_error() !== JSON_ERROR_NONE || !isset($datas->email, $datas->token, $datas->exp)) {
            session()->set('error', 'Token tidak valid.');
            return redirect("/login");
        }
    
        $email = filter_var($datas->email, FILTER_SANITIZE_EMAIL);
        $reset_token = $datas->token;
        $exp = (int) $datas->exp;
    
        // Check if the token is expired
        if (time() > $exp) {
            session()->set('error', 'Token telah kadaluarsa.');
            return redirect("/login");
        }
    
        // Optional: Verify user existence
        if (!$model->where("email","=",$email)->first()) {
            session()->set('error', 'Pengguna tidak ditemukan.');
            return redirect("/login");
        }
    
        // Render the reset password view if all checks pass
        return view("auth/reset_password", ['token' =>$token]);
    }
    
    // Function to validate token format
    private function isValidTokenFormat($token)
    {
        
        // Check for expected format of token, e.g., length, character set
        return preg_match('/^[A-Za-z0-9+\/=]+$/', $token);
    }
    


    public function gantiPasswordStore()
    {
        $model = new UserModel();
        $token = $_POST["token"] ?? '';
        $password = $_POST["password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';
        // Validate password and confirm password
        if (empty($password)) {
            $_SESSION["passwordErr"] = "Password baru tidak boleh kosong.";
            return redirect("/ganti-password?token=".$token);

        } elseif ($password !== $confirm_password) {
            $_SESSION["confirmPasswordErr"] = "Konfirmasi password tidak cocok.";
            return redirect("/ganti-password?token=".$token);

        }

        // Encrypt password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        if (!$token) {
            $_SESSION["error"] = "Token Tidak Ditemmukan. Silakan coba lagi.";
            return redirect("/ganti-password?token=".$token);

        }
        $data = [
            "password" => $hashed_password,
            "token_reset" => $token
        ];
        // Update password in the database
        $result = $model->where("token_reset","=",$token)->first();
    
        if ($model->update($result-> id, $data)) {

            // Password successfully updated
            $_SESSION["success"] = "Password berhasil diubah.";
            return redirect("/login");
        } else {
            // Error during update
            $_SESSION["error"] = "Terjadi kesalahan, coba lagi.";
            return redirect("/ganti-password?token=".$token);
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

        $result = $model->where("email","=",$email)->first();
       
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
            $model->update($result->id,$data);
           
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
                return redirect("/lupapassword");
            } catch (Exception $e) {
                echo "Pesan tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
