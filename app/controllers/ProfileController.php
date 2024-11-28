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
        // if (!auth()->check()) {
        //     redirect()->to('/login');
        // }

        $this->model = (object)[];
        $this->model->profile = new ProfilModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->user = new UserModel();
    }

    public function profile()
    {
        return view("admin/setting/profile");
    }

    public function uploadPP()
    {
        $ficon = $_FILES['profile_picture'] ?? null;
        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }

        $fileExt = pathinfo($ficon['name'], PATHINFO_EXTENSION);
        $allowedFileTypes = ["jpg", "jpeg", "png", "bmp", "webp", "svg"];
        $nameFile  = uniqid() . "." . $fileExt;
        $uploader = new FileUploader();
        $uploader->setFile($ficon);
        $uploader->setTarget(storagePath("public", "/assets/" . $nameFile));
        $uploader->setAllowedFileTypes($allowedFileTypes);
        $uploadStatus = $uploader->upload();

        $uploadStatus = $uploader->upload();

        if ($uploadStatus !== true) {
            $this->model->user->where("id", "=", auth()->user()->id)->update(["foto_profile" => $nameFile]);
            return response(["message" => "Berhasil Update", "success" => true]);
        }
        return response(["message" => "Berhasil Update"]);
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
        $password = request("password");

        $dataKK = [
            "password" => $password,
        ];

        $this->model->user->where("id", "=", auth()->user()->id)->update($dataKK);
        return redirect()->with("success", "Kata Sandi berhasil diubah")->back();
    }
}
