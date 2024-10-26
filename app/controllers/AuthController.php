<?php

namespace app\controllers;
use app\services\Database;
use PDO;
use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;
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
            $_SESSION["usenameErr"] = 'email tidak boleh kosong';
            $hasError = true;
        }
        
        if (empty($password)) {
            $_SESSION["passwordErr"] = 'Kata sandi tidak boleh kosong';
            $hasError = true;
        } else if (strlen($password) < 8) {
            $_SESSION["passwordErr"] = 'Kata sandi minimal 8 karakter';
            $hasError = true;
        }
        //Cek inputan ke database
        $user = "SELECT * FROM users where email = '$email'";
      $conn = (new Database())->getConnection(); 
      $result= $conn-> prepare ($user);
      $result->execute ();
      //var_dump ($result->fetch());
     // die ();
        if ($result->rowCount()>0) { 
           $data=$result->fetch(PDO::FETCH_ASSOC);
           if (password_verify ($password,$data['password'])){
            header("Location:/admin");
            return;
        }else  { 

            $_SESSION["passwordErr"] = 'Password salah';
            $hasError = true;
            //die();
           }
    
        } else { //kondisi jika E-mail tidak terdaftar
            $_SESSION["usernameErr"] = 'Username tidak terdaftar';
        }

        if (!$hasError) {
            // Login logic here      
        } else {
            header("Location:/login");
        }
   
    }

        public function lupaPassword()
        {
            return view("auth/lupapassword");


        }



        
        public function gantiPassword($token = null) {
            $model = new UserModel();
            // Simpan token ke sesi jika diperlukan untuk verifikasi nanti
            if ($token) {
                $data = base64_decode($token);
                var_dump($data);

                $datas = json_decode($data);

                $email = $datas->email;
                $reset_token =  $datas->token;
                $exp =  $datas->exp;
                if ($model->cekresettoken($reset_token)) { 
                    return view("auth/reset_password");
                }else {
                    return view("auth/login");
                }
                // return view("auth/reset_password");

            }else  {
            return view("auth/login");
            }
            // Tampilkan halaman reset password
            
        }
    
        public function ubahPassword($password, $confirm_password)
{
    // Validasi input password
    $errors = [];

    if (empty($password)) {
        $errors['passwordErr'] = "Password baru tidak boleh kosong.";
    }

    if ($password !== $confirm_password) {
        $errors['confirmPasswordErr'] = "Konfirmasi password tidak sesuai.";
    }

    // Jika ada error, simpan ke sesi untuk ditampilkan di form
    if (!empty($errors)) {
        $_SESSION = array_merge($_SESSION, $errors);
        header("Location: /reset-password"); // Redirect kembali ke halaman form
        exit;
    }

    // Hash password baru jika validasi berhasil
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Simpan password baru ke database
    $user_id = $_SESSION['user_id']; // Pastikan `user_id` sudah disimpan di sesi sebelumnya
    $db = badeansurat::getConnection(); // Pastikan kamu punya koneksi ke database

    $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
    if ($stmt->execute([$hashed_password, $user_id])) {
        // Password berhasil diubah, redirect ke halaman sukses
        $_SESSION['successMessage'] = "Password berhasil diubah.";
        header("Location: /login"); // Redirect ke halaman login atau halaman lain yang sesuai
        exit;
    } else {
        // Jika gagal menyimpan, tampilkan pesan error
        $_SESSION['errorMessage'] = "Terjadi kesalahan, silakan coba lagi.";
        header("Location: /reset-password");
        exit;
    }
}

        public function gantiPasswordStore()
        {
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
                // if ($stmt = $conn->prepare($sql)) {
                //     $stmt->bind_param("ss", $hashed_password, $email);
                //     if ($stmt->execute()) {
                //         // Password berhasil diubah
                //         $_SESSION["success"] = "Password berhasil diubah.";
                //         header("Location: login.php");
                //         exit();
                //     } else {
                //         // Jika terjadi kesalahan saat update
                //         $_SESSION["error"] = "Terjadi kesalahan, coba lagi.";
                //         header("Location: reset_password.php");
                //         exit();
                //     }
                // }
                // $stmt->close();
            }
            
        }

        public function kirimLinkReset()
        {
            // Tangani pengiriman link reset password
            $email = $_POST['email'];
            // Logika pengiriman email reset password
        }
        public function sendemail(){
            $model  = new UserModel();
            $email = $_POST['email'];
        
            $result = $model->cekuserbyemail($email);
            if ($result) {
                // Buat token
                $token = bin2hex(random_bytes(50)); // Generate random token
                $expiry = time() + 3600; // 1 jam ke depan
                $payload = json_encode(['email' => $email, 'token' => $token, 'exp' => $expiry]);
                $encodedToken = base64_encode($payload);
                $data = [
                    "token"=>$payload,
                    "email"=>$email
                ];
                // Simpan token dan tanggal kedaluwarsa di database
                $model->updatetokenreset($data);
                
                $resetLink = "http://localhost/SISURAT/ganti-password?token=" . $encodedToken;
                $mail = new PHPMailer(true);
                try {
                    // Pengaturan server SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com'; // Ganti dengan server SMTP Anda
                    $mail->SMTPAuth = true;
                    $mail->Username = 'mnorkholit7@gmail.com'; // Ganti dengan email Anda
                    $mail->Password = 'fcoyzvnhpodahuoh'; // Ganti dengan password email Anda
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // atau PHPMailer::ENCRYPTION_SMTPS
                    $mail->Port = 587; // Ganti dengan port yang sesuai

                    // Penerima
                    $mail->setFrom('Badean@gmail.com', 'Admin Badean');
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
                    echo 'Tautan reset password telah dikirim ke email Anda.';
                } catch (Exception $e) {
                    echo "Pesan tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}";
                }
                
            }
        }
          
        }


                    
                
        

           

    



   


    