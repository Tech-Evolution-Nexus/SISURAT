<?php

namespace apps\controllers;

use app\services\Database as ServicesDatabase;
use services\Database;
use PDO;
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
      $conn = (new ServicesDatabase())->getConnection(); 
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

}
