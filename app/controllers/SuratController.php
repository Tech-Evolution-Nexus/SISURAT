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
        
        // Validasi opsi adalah array
        if (empty($opsi) || !is_array($opsi)) {
            session()->flash("fields","Tidak ada data yang diterima.");
        }
        
        // Validasi file yang diunggah
        if (empty($ficon['name'])) {
            session()->flash("file_icon","File icon tidak boleh kosong.");
        }
        
        // Validasi ukuran file maksimal (contoh: 2MB)
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        if ($ficon['size'] > $maxFileSize) {
            session()->flash("file_icon","Ukuran file terlalu besar. Maksimal 2MB.");
        }
        
        // Set tipe file yang diizinkan
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($ficon, "../upload/", $allowedFileTypes);
        
        // Unggah file jika validasi berhasil
        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            session()->flash("file_icon",$uploadStatus);
        }
        
        // Tampilkan nama surat dan opsi yang diterima
        echo "Nama Surat: " . htmlspecialchars($namasur) . "<br>";
        echo "File Icon berhasil diunggah.<br>";
        echo "<ul>";
        foreach ($opsi as $field) {
            echo "<li>" . htmlspecialchars($field) . "</li>";
        }
        echo "</ul>";
    }
}
