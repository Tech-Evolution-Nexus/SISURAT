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
        // var_dump(password_hash("admin",PASSWORD_BCRYPT));
        // die();
        // $user = $this ->model->user->where('id','=',auth()->user()->nik)->first();
        // dd(auth()->user());
        return view("admin/setting/profile");

    }

    
    
    public function uploadPP() {
        $ficon = $_FILES['file_icon'] ?? null;
        $ficonName = $ficon['name'];
        $fileType = strtolower(pathinfo($ficon['name'], PATHINFO_EXTENSION));
        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($fileType, $ficon, "../upload/photoprofile/", $allowedFileTypes);
        $uploadSs = $uploader->isAllowedFileType();
        if ($uploadSs !== true) {
            return redirect()->with("error", "$uploadSs")->back();
        }

        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            return redirect()->with("success", "$uploadStatus")->back();
        }
        return redirect()->with("success", "Data berhasil ditambahkan.")->back();

        $fileExt = pathinfo($ficon['name'], PATHINFO_EXTENSION);
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $nameFile  = uniqid() . "." . $fileExt;
        $uploader = new FileUploader();
        $uploader->setFile($ficon);
        $uploader->setTarget(storagePath("private", "/berita/" . $nameFile));
        $uploader->setAllowedFileTypes($allowedFileTypes);
        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            return redirect()->with("error", "$uploadStatus")->back();
        }
    }

    public function update_profile() {
        $dataKK = [
            "email" => $email,
            "no_hp" => $noHP,
            "password" => $kataSandi,

        ];

        $kk  =  $this->model->profile->where("no_nik", "=", $id)->first();
        if ($foto_kartu_keluarga["name"] !== "") {
            $file_extension = pathinfo($foto_kartu_keluarga['name'], PATHINFO_EXTENSION);
            $randomName = uniqid() . '.' . $file_extension;
            $fileUpload = new FileUploader();
            $fileUpload->setFile($foto_kartu_keluarga);
            $fileUpload->setTarget(storagePath("private", "/kartu_keluarga/" . $randomName));
            $fileUpload->upload();
            $fileUpload->delete(storagePath("private", "/kartu_keluarga/" . $kk->kk_file));
            $dataKK["kk_file"] = $randomName;
        }
        $this->model->kartuKeluarga->where("no_kk", "=", $id)->update($dataKK);

        $this->model->masyarakat->where("nik", "=", $idMasyarakat)->update([
            "nik" => $nik,
            "nama_lengkap" => $nama,
            "no_kk" => $noKK
        ]);


        return redirect()->with("success", "Kartu keluarga berhasil diubah")->to("/admin/kartu-keluarga");
    }
}
