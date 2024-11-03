<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use FileUploader;

class SuratController extends Controller
{
    private $model;


    function __construct()
    {
        $this->model =  (object)[];
        $this->model->jsurat  = new JenisSuratModel();
        $this->model->lampiran  = new LampiranModel();
        $this->model->lampiransurat  = new LampiranSuratModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
    }
    public function index()
    {

        $datasurat = $this->model->jsurat->all();
        $datalampiran = $this->model->lampiran->all();

        $params["data"] = (object)[
            "title" => "Jenis Surat",
            "description" => "Kelola Jenis dengan mudah",
            "datasurat" => $datasurat,
            "datalampiran" => $datalampiran,
        ];
        return view("admin/surat/surat", $params);
    }
    public function add()
    {
        $namasur = $_POST['nama_surat'] ?? null;
        $ficon = $_FILES['file_icon'] ?? null;
        $opsi = $_POST['fields'] ?? [];
        if (empty($namasur)) {
            session()->flash("namasur", "Nama surat tidak boleh kosong.");
        }

        if (empty($opsi) || !is_array($opsi)) {
            session()->flash("fields", "Tidak ada data yang diterima.");
        }

        if (empty($ficon['name'])) {
            session()->flash("file_icon", "File icon tidak boleh kosong.");
        }

        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            session()->flash("file_icon", "Ukuran file terlalu besar. Maksimal 2MB.");
        }
        $d = $this->model->jsurat->select()->where("nama_surat", "=",$namasur)->first();
        if($d){
            session()->flash("namasurat", "Data Sudah Terdaftar");
            return;
        }
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($ficon, "../upload/", $allowedFileTypes);
        $idsur = $this->model->jsurat->create(
            [
                "nama_surat" => $namasur,
                "image" => $ficon['name']
            ]
        );

        foreach ($opsi as $data) {

            // Cek apakah kombinasi id_surat dan id_lampiran sudah ada
            $exists = $this->model->lampiransurat->exists([
                'id_surat' => $idsur,
                'id_lampiran' => $data
            ]);

            if ($exists) {
                // Jika sudah ada, tampilkan notifikasi
                echo "Kombinasi id_surat $idsur dan id_lampiran $data sudah tersimpan di database.";
                return;
            } else {
                // Jika belum ada, lakukan insert data
                $d = true;
            }
        }
        if ($d) {
            foreach ($opsi as $data) {
                $this->model->lampiransurat->create([
                    'id_surat' => $idsur,
                    'id_lampiran' => $data
                ]);
            }
        }

        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            session()->flash("file_icon", $uploadStatus);
        }
    }
    public function getedit($id)
    {

        $datasurat = $this->model->jsurat->where("id", "=", $id)->first();
        $data = $this->model->lampiransurat->select("id_surat", "lampiran.id", "nama_lampiran")
            ->join("lampiran", "lampiran.id", "id_lampiran")->where("id_surat", "=", $id)->get();
        $params = [
            "datasurat" => $datasurat,
            "datalampiran" => $data,
        ];
        return response($params, 200);
        // return view("admin/surat/surat", $params);
    }
    public function deletedata($id)
    {
        $this->model->jsurat->where("id", "=", $id)->delete();
        $this->model->lampiransurat->where("id_surat", "=", $id)->delete();
        return redirect("/admin/surat");
    }
    public function edit($id)
    {

        $namasur = $_POST['nama_surat'] ?? null;
        $ficon = $_FILES['file_icon'] ?? null;
        $opsi = $_POST['fields'] ?? [];

        if (empty($namasur)) {
            session()->flash("namasur", "Nama surat tidak boleh kosong.");
        }

        if (empty($opsi) || !is_array($opsi)) {
            session()->flash("fields", "Tidak ada data yang diterima.");
        }

        if (empty($ficon['name'])) {
            session()->flash("file_icon", "File icon tidak boleh kosong.");
        }

        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            session()->flash("file_icon", "Ukuran file terlalu besar. Maksimal 2MB.");
        }

        die();
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($ficon, "../upload/", $allowedFileTypes);
        $idsur = $this->model->jsurat->update(
            $id,
            [
                "nama_surat" => $namasur,
                "image" => $ficon['name']
            ]
        );

        foreach ($opsi as $data) {
            $exists = $this->model->lampiransurat->exists([
                'id_surat' => $idsur,
                'id_lampiran' => $data
            ]);

            if ($exists) {
                // Jika sudah ada, tampilkan notifikasi
                echo "Kombinasi id_surat $idsur dan id_lampiran $data sudah tersimpan di database.";
                return;
            } else {
                // Jika belum ada, lakukan insert data
                $d = true;
            }
        }
        if ($d) {
            foreach ($opsi as $data) {
                $this->model->lampiransurat->update($data, [
                    'id_surat' => $idsur,
                    'id_lampiran' => $data
                ]);
            }
        }
        $uploader->delete("example.jpg");
        $uploadStatus = $uploader->upload();
        if ($uploadStatus !== true) {
            session()->flash("file_icon", $uploadStatus);
        }
        return redirect("/admin/surat");
    }
}
