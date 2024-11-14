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
        $fileType = strtolower(pathinfo($ficon['name'], PATHINFO_EXTENSION));

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
        $opsiUnik = array_unique($opsi);

        if (count($opsi) !== count($opsiUnik)) {
            return redirect()->with("error", "Terdapat data duplikat dalam pilihan Anda.")->back();
        }
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
        $uploader = new FileUploader($namasur . "." . $fileType, $ficon, "/surat", $allowedFileTypes);
        $uploadSs = $uploader->isAllowedFileType();
        if ($uploadSs !== true) {
            return redirect()->with("error", "$uploadSs")->back();
        }
        $idsur = $this->model->jsurat->create(
            [
                "nama_surat" => $namasur,
                "image" => $namasur . "." . $fileType
            ]
        );
        foreach ($opsi as $data) {
            $this->model->lampiransurat->create([
                'id_surat' => $idsur,
                'id_lampiran' => $data
            ]);
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

        $fileType =
            strtolower(pathinfo($ficon['name'], PATHINFO_EXTENSION));
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
        $opsiUnik = array_unique($opsi);

        if (count($opsi) !== count($opsiUnik)) {
            return redirect()->with("error", "Terdapat data duplikat dalam pilihan Anda.")->back();
        }

        $fileName = $existingData->image;
        if (!empty($ficon['name'])) {
            $maxFileSize = 2 * 1024 * 1024;
            if ($ficon['size'] > $maxFileSize) {
                return redirect()->with("error", "Ukuran file terlalu besar. Maksimal 2MB.")->back();
            }

            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $uploader = new FileUploader($namasur . "." . $fileType, $ficon, "/surat", $allowedFileTypes);

            // Hapus file lama jika ada dan nama file baru berhasil diunggah
            $uploadStatus = $uploader->upload();
            if ($uploadStatus === true) {
                if ($fileName && file_exists("../upload/surat/" . $fileName)) {
                    unlink("../upload/surat/" . $fileName); // Hapus file lama
                }
                $fileName = $ficon['name'];
                return redirect()->with("success", "Data berhasil Diubah.")->back();
                // Set nama file baru
            } else {
                return redirect()->with("error", "$uploadStatus")->back();
            }
        }

        // Update data surat
        $updateData = [
            "nama_surat" => $namasur,
            "image" => $fileName // Set ke nama file lama atau baru tergantung ada perubahan atau tidak
        ];
        $this->model->jsurat->where("id", "=", $id)->update($updateData);


        foreach ($opsi as $data) {
            $this->model->lampiransurat->where("id_surat", "=", $id)->update([
                'id_surat' => $id,
                'id_lampiran' => $data
            ]);
        }

        return redirect("/admin/surat")->with("success", "Data berhasil diupdate.");
    }
}
