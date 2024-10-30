<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\JenisSuratModel;
use FileUploader;

class SuratController extends Controller
{
    private $model;
    function __construct()
    {
        $this->model  = new JenisSuratModel();
    }
    public function index()
    {

        $data = $this->model->all();
        $params["data"] = (object)[
            "title" => "Jenis Surat",
            "description" => "Kelola Jenis dengan mudah",
            "data" => $data
        ];
        return view("admin/surat/surat", $params);
    }
    public function add()
    {
        $namasur = $_POST['nama_surat'] ?? null;
        $ficon = $_FILES['file_icon'] ?? null;
        $opsi = $_POST['fields'] ?? [];
        if (empty($namasur)) {
            session()->flash("namasur","Nama surat tidak boleh kosong.");
        }

        if (empty($opsi) || !is_array($opsi)) {
            session()->flash("fields","Tidak ada data yang diterima.");
        }

        if (empty($ficon['name'])) {
            session()->flash("file_icon","File icon tidak boleh kosong.");
        }

        $maxFileSize = 2 * 1024 * 1024; 
        if ($ficon['size'] > $maxFileSize) {
            session()->flash("file_icon","Ukuran file terlalu besar. Maksimal 2MB.");
        }
        

        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($ficon, "../upload/", $allowedFileTypes);
        $idsur = $this->model->create(
            [
                "nama_surat"=>$namasur,
                "image"=>$ficon['name']]);
                
        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            session()->flash("file_icon",$uploadStatus);
        }
        
    }
}
