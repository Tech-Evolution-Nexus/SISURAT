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
        public function gantiPassword()
        {dd('sembarang');
            return view("auth/proses_ganti_password");


        }
        public function gantiPasswordStore()
        {


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
                
                $resetLink = "http://localhost/ganti-password?token=" . $encodedToken;
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



   

?>

    