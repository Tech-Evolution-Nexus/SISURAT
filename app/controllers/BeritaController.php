<?php

namespace app\controllers;

use app\models\BeritaModel;
use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;

use Exception;
use FileUploader;

class BeritaController
{
    public $model;
    // private $model;
    public function __construct()
    {
        if (!auth()->check()) {
            redirect("/login");
        }
        $this->model = (object)[];
        $this->model->beritamodel = new BeritaModel();
    }
    public function index()
    {
        $data  = $this->model->beritamodel->select()->get();
        $params["data"] = (object)[
            "title" => "Berita",
            "description" => "Kelola Berita Dengan Mudah",
            "data" => $data
        ];
        return view('admin/berita/berita', $params);
    }
    public function add()
    {
        request()->validate([
            "judul" => "required",
            "subjudul" => "required",
            "deskripsi" => "required",
            "file_berita" => "required",
        ]);

        $jud = $_POST['judul'] ?? null;
        $sub = $_POST['subjudul'] ?? null;
        $des = $_POST['deskripsi'] ?? null;
        $ficon = $_FILES['file_berita'] ?? null;

        $fileType = strtolower(pathinfo($ficon['name'], PATHINFO_EXTENSION));
        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }
        $d = $this->model->beritamodel->select()->where("judul", "=", $jud)->first();
        if ($d) {
            return redirect()->with("error", "Data Sudah Terdaftar.")->back();
        }
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

        $idsur = $this->model->beritamodel->create(
            [
                "judul" => $jud,
                "sub_judul" => $sub,
                "deskripsi" => $des,
                "gambar" => $nameFile,
            ]
        );


        return redirect()->with("success", "Data berhasil ditambahkan.")->back();
    }
    public function update($id)
    {
        request()->validate([
            "judul" => "required",
            "subjudul" => "required",
            "deskripsi" => "required",
            "file_berita" => "nullable|file",
        ]);

        $jud = $_POST['judul'] ?? null;
        $sub = $_POST['subjudul'] ?? null;
        $des = $_POST['deskripsi'] ?? null;
        $ficon = $_FILES['file_berita'] ?? null;
        $fileType = strtolower(pathinfo($ficon['name'], PATHINFO_EXTENSION));

        // Check if the entry exists
        $d = $this->model->beritamodel->select()->where("id", "=", $id)->first();
        if (!$d) {
            return redirect()->with("error", "Data tidak ditemukan.")->back();
        }

        // Check file size if a new file is provided
        if ($ficon && $ficon['size'] > 0) {
            $maxFileSize = 2 * 1024 * 1024;
            if ($ficon['size'] > $maxFileSize) {
                return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
            }

            // File type validation

            $fileExt = pathinfo($ficon['name'], PATHINFO_EXTENSION);
            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $nameFile  = uniqid() . "." . $fileExt;
            $uploader = new FileUploader();
            $uploader->setFile($ficon);
            $uploader->setTarget(storagePath("private", "/berita/" . $nameFile));
            $uploader->setAllowedFileTypes($allowedFileTypes);
            $uploadStatus = $uploader->upload();
            $uploader->delete(storagePath("private", "/berita/" . $d->gambar));
            if ($uploadStatus !== true) {

                return redirect()->with("error", "$uploadStatus")->back();
            }


            // Update with new file name
            $updateData = [
                "judul" => $jud,
                "sub_judul" => $sub,
                "deskripsi" => $des,
                "gambar" => $nameFile
            ];
        } else {
            // Update without changing the file
            $updateData = [
                "judul" => $jud,
                "sub_judul" => $sub,
                "deskripsi" => $des
            ];
        }

        // Perform the update
        $this->model->beritamodel->where("id", "=", $id)->update($updateData);

        return redirect()->with("success", "Data berhasil diperbarui.")->back();
    }

    public function delete($id)
    {
        $berita = $this->model->beritamodel->where("id", "=", $id)->first();
        $this->model->beritamodel->where("id", "=", $id)->delete();
        $fileUpload = new FileUploader();
        $fileUpload->delete(storagePath("private", "/berita/" . $berita->gambar));
        return redirect("/admin/berita");
    }
    public function getedit($id)
    {
        $datasurat = $this->model->beritamodel->where("id", "=", $id)->first();
        $datasurat->gambar = url("/admin/assetsberita/" . $datasurat->gambar);

        $params = [
            "data" => $datasurat,
        ];
        return response($params, 200);
    }
}
