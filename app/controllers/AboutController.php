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

        $data = $this->model->about->first();
        return view("admin/setting/tentangAplikasi", ["data" => $data]);
    }

    public function update_about()
    {
        // Ambil data dari request
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
    
        // Pengaturan upload
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        $allowedFileTypes = ["jfif", "jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
    
        // Upload image_hero
        $ficonHero = $_FILES['image_hero'] ?? null;
        if ($ficonHero && $ficonHero['error'] === UPLOAD_ERR_OK) {
            $fileExtHero = pathinfo($ficonHero['name'], PATHINFO_EXTENSION);
            if ($ficonHero['size'] > $maxFileSize) {
                return redirect()->with("error", "Ukuran file 'image_hero' terlalu besar. Maksimal 2MB.")->back();
            }
            if (!in_array(strtolower($fileExtHero), $allowedFileTypes)) {
                return redirect()->with("error", "Format file 'image_hero' tidak didukung.")->back();
            }
            $nameFileHero = uniqid() . "." . $fileExtHero;
            $uploadPathHero = storagePath("public", "/assets/hero-img.png");
    
            $uploaderHero = new FileUploader();
            $uploaderHero->setFile($ficonHero);
            $uploaderHero->setTarget($uploadPathHero);
            $uploaderHero->setAllowedFileTypes($allowedFileTypes);
    
            if ($uploaderHero->upload() === true) {
                $fieldTentang['image_hero'] = "hero-img.png";
            } else {
                return redirect()->with("error", "Gagal mengunggah file 'image_hero'.")->back();
            }
        }
    
        // Upload image_logo
        $ficonLogo = $_FILES['image_logo'] ?? null;
        if ($ficonLogo && $ficonLogo['error'] === UPLOAD_ERR_OK) {
            $fileExtLogo = pathinfo($ficonLogo['name'], PATHINFO_EXTENSION);
            if ($ficonLogo['size'] > $maxFileSize) {
                return redirect()->with("error", "Ukuran file 'image_logo' terlalu besar. Maksimal 2MB.")->back();
            }
            if (!in_array(strtolower($fileExtLogo), $allowedFileTypes)) {
                return redirect()->with("error", "Format file 'image_logo' tidak didukung.")->back();
            }
            $nameFileLogo = uniqid() . "." . $fileExtLogo;
            $uploadPathLogo = storagePath("public", "/assets/logo-badean.png");
    
            $uploaderLogo = new FileUploader();
            $uploaderLogo->setFile($ficonLogo);
            $uploaderLogo->setTarget($uploadPathLogo);
            $uploaderLogo->setAllowedFileTypes($allowedFileTypes);
    
            if ($uploaderLogo->upload() === true) {
                $fieldTentang['img_logo'] = "logo-badean.png";
            } else {
                return redirect()->with("error", "Gagal mengunggah file 'image_logo'.")->back();
            }
        }
    
        // Simpan perubahan ke database
        $this->model->about->where("id", "=", 1)->update($fieldTentang);
    
        // Redirect dengan pesan sukses
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
