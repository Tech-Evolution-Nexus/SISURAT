<?php

namespace app\controllers;

use app\services\Database as ServicesDatabase;
use services\Database;
use PDO;

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
            return redirect("/login");
        }
    }
}
