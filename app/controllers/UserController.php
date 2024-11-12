<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\UserModel;


class UserController extends Controller
{
    private $model;

    public function __construct()
    {
        $this->model = (object)[];
        $this->model->user = new UserModel();
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
        $data = $this->model->user->select("id, nama_lengkap,users.nik,email,users.no_hp,role")
            ->join("masyarakat", "users.nik", "masyarakat.nik")
            ->orderBy("users.created_at", "desc")
            ->get();


        $params["data"] = (object)[
            "title" => "Manajemen Pengguna",
            "description" => "Kelola pengguna dengan mudah",
            "data" => $data
        ];

        return $this->view("admin/user/user", $params);
    }
    // Menampilkan form pembuatan pengguna
    // Menyimpan pengguna baru
    // Menampilkan form untuk mengedit pengguna
    public function edit($id)
    {
        $user = $this->model->user->join("masyarakat", "users.nik", "masyarakat.nik")
            ->find($id);
        if (!$user) {
            return show404();
        }

        $data = (object)[

            "name" => $user->nama_lengkap ?? null,
            "nik" => $user->nik ?? null,
            "email" => $user->email ?? null,
            "no_hp" => $user->no ?? null,
            "role" => $user->role ?? null,
        ];

        $params["data"] = (object)[
            "title" => "Edit Pengguna",
            "description" => "Kelola pengguna dengan mudah",
            "action_form" => url("/admin/users/update/$id"),
            "data" => $data
        ];

        return $this->view("admin/user/form", $params);
    }

    // Memperbarui pengguna yang ada
    public function update($id)
    {

        $password = request("password");

        if ($password) {
            $this->model->user->where("id", "=", $id)->update([
                "password" => password_hash($password, PASSWORD_BCRYPT),

            ]);
        }

        return redirect()->with("success", "Pengguna berhasil diperbarui")->to("/admin/users");
    }

    // Menghapus pengguna
    public function delete($id)
    {
        $user = $this->model->user->find($id);

        if (!$user) {
            return redirect()->with("error", "Pengguna tidak ditemukan")->back();
        }

        $this->model->user->where("id", "=", $id)->delete();

        return redirect()->with("success", "Pengguna berhasil dihapus")->to("/admin/users");
    }
}
