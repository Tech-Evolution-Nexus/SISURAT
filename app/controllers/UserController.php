<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\UserModel;

class UserController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->all(); // Ganti dengan fungsi yang sesuai

        $params["data"] = (object)[
            "title" => "Users",
            "description" => "Kelola Users anda",
            "data" => $users
        ];
        $this->view('admin/user/user', $params);
    }



    public function create()
    {
        $params["data"] = (object)[
            "title" => "Tambah User",
            "description" => "Kelola User Dengan Mudah",
            "action_form" => "/admin/users/store",
            "data" => (object)[
                "email" => "",
                "no_hp" => "",
                "role" => ""
            ]
        ];
        return $this->view("admin/user/form", $params);
    }

    public function store()
    {
        $data = [
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'no_hp' => $_POST['no_hp'],
            'role' => $_POST['role'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->userModel->create($data);
        return redirect('/admin/users');
    }

    public function edit($id)
    {
        $user = $this->userModel->getById($id);
        $params["data"] = (object)[
            "title" => "Edit User",
            "description" => "Ubah data user",
            "action_form" => "/admin/users/update/$id",
            "data" => $user
        ];
        return $this->view("admin/user/form", $params);
    }

    public function update($id)
    {
        $data = [
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'no_hp' => $_POST['no_hp'],
            'role' => $_POST['role']
        ];
        $this->userModel->update($id, $data);
        return redirect('/admin/users');
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect('/admin/users');
    }
}
