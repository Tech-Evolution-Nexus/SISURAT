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
            return redirect()->with("error", "Nama surat tidak boleh kosong.")->back();
        }

        if (empty($opsi) || !is_array($opsi)) {
            return redirect()->with("error", "Tidak ada data yang diterima.")->back();
        }

        if (empty($ficon['name'])) {
            return redirect()->with("error", "File icon tidak boleh kosong.")->back();
        }

        $maxFileSize = 2 * 1024 * 1024;
        if ($ficon['size'] > $maxFileSize) {
            return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
        }
        $d = $this->model->jsurat->select()->where("nama_surat", "=", $namasur)->first();
        if ($d) {
            return redirect()->with("error", "Data Sudah Terdaftar.")->back();
        }
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($ficon, "../upload/", $allowedFileTypes);
        $uploadSs = $uploader->isAllowedFileType();
        if ($uploadSs !== true) {
            return redirect()->with("error", "$uploadSs")->back();
        }
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

                return redirect()->with("error", "Kombinasi id_surat $idsur dan id_lampiran $data sudah tersimpan di database.")->back();
            } else {

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
            return redirect()->with("success", "$uploadStatus")->back();
        }
        return redirect()->with("success", "Data berhasil ditambahkan.")->back();
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
        $this->model->lampiransurat->where("id_surat", "=", $id)->delete();
        $this->model->jsurat->where("id", "=", $id)->delete();
      
        return redirect("/admin/surat");
    }
    public function edit($id)
    {
        $namasur = $_POST['nama_surat'] ?? null;
        $ficon = $_FILES['file_icon'] ?? null;
        $opsi = $_POST['fields'] ?? [];

        // Validasi nama surat
        if (empty($namasur)) {
            return redirect()->with("error", "Nama surat tidak boleh kosong.")->back();
        }

        // Validasi opsi
        if (empty($opsi) || !is_array($opsi)) {
            return redirect()->with("error", "Tidak ada data yang diterima.")->back();
        }

        // Ambil data surat lama dari database
        $existingData = $this->model->jsurat->find($id);
     
        if (!$existingData) {
            return redirect()->with("error", "Data tidak ditemukan.")->back();
        }
        $fileName = $existingData->image;
        if (!empty($ficon['name'])) {
            $maxFileSize = 2 * 1024 * 1024;
            if ($ficon['size'] > $maxFileSize) {
                return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
            }

            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $uploader = new FileUploader($ficon, "../upload/", $allowedFileTypes);

            // Hapus file lama jika ada dan nama file baru berhasil diunggah
            $uploadStatus = $uploader->upload();
            if ($uploadStatus === true) {
                if ($fileName && file_exists("../upload/" . $fileName)) {
                    unlink("../upload/" . $fileName); // Hapus file lama
                }
                $fileName = $ficon['name']; // Set nama file baru
            } else {
                return redirect()->with("error", "$uploadStatus")->back();
            }
        }

        // Update data surat
        $updateData = [
            "nama_surat" => $namasur,
            "image" => $fileName // Set ke nama file lama atau baru tergantung ada perubahan atau tidak
        ];
       $this->model->jsurat->where("id","=",$id)->update($updateData);

        // Update lampiran surat
        foreach ($opsi as $data) {
            $exists = $this->model->lampiransurat->exists([
                'id_surat' => $id,
                'id_lampiran' => $data
            ]);

            // if (!$exists) {
                // $this->model->lampiransurat->where("id_surat","=",$id)->update( [
                //     'id_surat' => $id,
                //     'id_lampiran' => $data
                // ]);
            // } else {
            //     return redirect()->with("error", "Kombinasi id_surat $id dan id_lampiran $data sudah tersimpan di database.")->back();
            // }
            $this->model->lampiransurat->where("id_surat","=",$id)->update( [
                'id_surat' => $id,
                'id_lampiran' => $data
            ]);
        }

        return redirect("/admin/surat")->with("success", "Data berhasil diupdate.");
    }
}
