<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\MasyarakatModel;
use app\models\ProfilModel;
use app\models\UserModel;
use FileUploader;


class ProfileController extends Controller
{
    private $model;
    public  function __construct()
    {
        if (!auth()->check()) {
            redirect()->to('/login');
        }

        $this->model = (object)[];
        $this->model->profile = new ProfilModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->user = new UserModel();
    }

    public function profile()
    {
        $params["data"] = (object)[
            "title" => "Profile",
            "description" => "Edit informasi admin",
        ];

        return view("admin/setting/profile");
    }

    public function uploadPP()
    {
        try {
            $ficon = $_FILES['profile_picture'] ?? null;
            $maxFileSize = 2 * 1024 * 1024;
            if ($ficon['size'] > $maxFileSize) {
                return response(["message" => "Ukuran file terlalu besar"]);
            }

            $fileExt = pathinfo($ficon['name'], PATHINFO_EXTENSION);
            $allowedFileTypes = ["jfif", "jpg", "jpeg", "png", "bmp", "webp", "svg"];
            $nameFile  = uniqid() . "." . $fileExt;
            $uploader = new FileUploader();
            $uploader->setFile($ficon);
            $uploader->setTarget(storagePath("public", "/assets/profile/" . $nameFile));
            $uploader->setAllowedFileTypes($allowedFileTypes);
            $uploadStatus = $uploader->upload();

            $uploadStatus = $uploader->upload();

            if ($uploadStatus !== true) {
                $this->model->user->where("id", "=", auth()->user()->id)->update(["foto_profile" => $nameFile]);
                return response(["message" => "Berhasil Update", "success" => true]);
            }
            return response(["message" => "Berhasil Update"]);
        } catch (\Throwable $th) {
            //throw $th;
            return response(["message" => $th->getMessage()], 500);
        }
    }

    public function update_data()
    {
        $email = request("email");
        $noHP = request("no_hp");

        $dataKK = [
            "email" => $email,
            "no_hp" => $noHP,
        ];

        $this->model->user->where("id", "=", auth()->user()->id)->update($dataKK);
        return redirect()->with("success", "Data berhasil diubah")->back();
    }

    public function update_password()
    {
        request()->validate([
            "password" => "required|min:8",
            "newpass" => "required|min:8",
            "confirmpass" => "required|min:8|same:password",
        ], [
            "password.required" => "Password wajib diisi",
            "newpass.required" => "Masukkan password baru terlebih dahulu",
            "confirmpass.required" => "Konfirmasi password wajib diisi",
            "newpass.min" => "Password minimal 8 karakter",
            "confirmpass.min" => "Konfirmasi password  minimal 8 karakter",
            "confirmpass.same" => "Konfirmasi password  tidak sama",
        ]);
        $password = request("password");
        $newpass = request("newpass");


        $userData = [
            "password" => $newpass,

        ];

        $user = $this->model->user->where("id","=",auth()->user()->id)->first();

        if (password_verify($password, hash: $user->password)) {
            $this->model->user->where("id", "=", auth()->user()->id)->update($userData);
            return redirect()->with("success", "Kata Sandi berhasil diubah")->back();
        } else {
            return redirect()->with("error", "Password salah")->back();
           
        }
    }
}
