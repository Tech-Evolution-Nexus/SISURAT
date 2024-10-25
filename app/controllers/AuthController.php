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
                $token = bin2hex(random_bytes(50));
                $expire = date("Y-m-d H:i:s", strtotime('+1 hour'));
        
                // Simpan token dan tanggal kedaluwarsa di database
                $model->updatetokenreset($token,$expire,$email);
        
                // Mengirim email
                $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                try {
                    // Pengaturan server
                    $mail->isSMTP();
                    $mail->Host = 'smtp.example.com'; // Ganti dengan server SMTP yang kamu gunakan
                    $mail->SMTPAuth = true;
                    $mail->Username = 'your_email@example.com'; // Alamat email pengirim
                    $mail->Password = 'your_password'; // Password email pengirim
                    $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS; // Atau PHPMailer::ENCRYPTION_SMTPS
                    $mail->Port = 587; // Port SMTP
        
                    // Penerima
                    $mail->setFrom('your_email@example.com', 'Nama Pengirim');
                    $mail->addAddress($email);
        
                    // Konten email
                    $mail->isHTML(true);
                    $mail->Subject = 'Reset Password';
                    $mail->Body = "Klik link berikut untuk reset password: <a href='https://yourdomain.com/reset_password.php?token=$token'>Reset Password</a>";
        
                    // Mengirim email
                    $mail->send();
                    echo "Link reset password telah dikirim ke email Anda.";
                } catch (Exception $e) {
                    echo "Email tidak dapat dikirim. Kesalahan: {$mail->ErrorInfo}";
                }
            } else {
                echo "Email tidak ditemukan.";
            }
        }
}

   

?>

    