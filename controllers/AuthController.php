<?php

namespace controllers;

class AuthController
{
    public  function index()
    {
        return view("auth/login");
    }

    public function authentic()
    {
        
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hasError = false;
        if (empty($username)) {
            $_SESSION["usenameErr"] = 'Username tidak boleh kosong';
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
        $user = "SELECT * FROM user where user = $username";
        if ($user) { //kondisi jika Username terdaftar
            if (md5($password) === $user) {
                $_SESSION["user"] = $user;
                header("Location:/login");
                //Mengirim user ke Dashboard
            } else { //kondisi jika password salah
                $_SESSION["usernameErr"] = 'Password salah';
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
