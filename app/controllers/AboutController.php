<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\AboutModel;
use FileUploader;

class AboutController extends Controller
{
    private $model;
    public  function __construct()
    {
        if (!auth()->check()) {
            redirect()->to('/login');
        }

        $this->model = (object)[];
        $this->model->about = new AboutModel();

    }

    public function index()
    {
        return view("admin/setting/tentangAplikasi");
        
    }

    public function uploadPP()
    {
        $ficon = $_FILES['image_hero'] ?? null;
        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }

        $fileExt = pathinfo($ficon['name'], PATHINFO_EXTENSION);
        $allowedFileTypes = ["jfif", "jpg", "jpeg", "png", "gif" , "bmp", "webp", "svg"];
        $nameFile  = uniqid() . "." . $fileExt;
        $uploader = new FileUploader();
        $uploader->setFile($ficon);
        $uploader->setTarget(storagePath("public", "/assets/" . $nameFile));
        $uploader->setAllowedFileTypes($allowedFileTypes);
        $uploadStatus = $uploader->upload();

        $uploadStatus = $uploader->upload();

        if ($uploadStatus !== true) {
            $this->model->about->where("id", "=", 1)->update(["image_hero" => $nameFile]);
            return response(["message" => "Berhasil Update", "success" => true]);
        }
        return response(["message" => "Berhasil Update"]);
    }

    public function update_about()
    {
        $websiteName = request("nama_website");
        $homeTitle = request("judul_home");
        $homeDesc = request("deskripsi_home");
        $aboutTitle = request("judul_about");
        $downloadLink = request("link_download");
        $aboutApp = request("tentang_aplikasi");
        $neighbourhoodEmail = request("email_kelurahan");
        $neighbourhoodPhone = request("no_telp");
        $neighbourhoodAddress = request("alamat_kelurahan");
        $urlVideo = request("video_url");

        $fieldTentang = [
            "nama_website" => $websiteName,
            "judul_home" => $homeTitle,
            "deskripsi_home" => $homeDesc,
            "judul_tentang" => $aboutTitle,
            "link_download" => $downloadLink,
            "tentang_aplikasi" => $aboutApp,
            "email_kelurahan" => $neighbourhoodEmail,
            "no_telp" => $neighbourhoodPhone,
            "alamat_kelurahan" => $neighbourhoodAddress,
            "video_url" => $urlVideo,
        ];

        $this->model->about->where("id", "=", 1)->update($fieldTentang);
        return redirect()->with("success", "Data berhasil diubah")->back();
        
    }



        // public  function edit_about()
    // {
    //     $id = request("id");
    //     $landing = $this->model->landing->find($id);
    //     if (!$landing) return show404();
    //     $data = (object)[
    //         "nama_website" => $websiteName ?? null,
    //         "judul_home" => $homeTitle ?? null,
    //         "deskripsi_home" => $homeDesc ?? null,
    //         "image_hero" => $imgHero ?? null,
    //         "judul_tentang" => $aboutTitle ?? null,
    //         "link_download" => $downloadLink ?? null,
    //         "tentang_aplikasi" => $aboutApp ?? null,
    //         "email_kelurahan" => $neighbourhoodEmail ?? null,
    //         "no_telp" => $neighbourhoodPhone ?? null,
    //         "alamat_kelurahan" => $neighbourhoodAddress ?? null,
    //         "video_url" => $urlVideo ?? null,
    //     ];

    //     $params["data"] = (object)[
    //         "title" => "Ubah Landing Page",
    //         "description" => "Kelola Halaman Landing Page dengan mudah",
    //         "action_form" => url("/setting/landing/$id"),
    //         "data" => $data
    //     ];

    //     return view("admin/setting/tentangAplikasi", $params);
    // }

}
