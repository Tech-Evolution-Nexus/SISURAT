<?php

namespace app\controllers;

use app\abstract\Controller;
use app\import\KartuKeluargaImport;
use app\models\FormatSuratModel;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\UserModel;
use FileUploader;

class FormatSuratController extends Controller
{
    private $model;
    public function __construct()
    {
        if (!auth()->check()) {
            redirect("/login");
        }

        $this->model =  (object)[];
        $this->model->formatSurat = new FormatSuratModel();
    }
    public  function index()
    {
        $data = $this->model->formatSurat
            ->get();

        $params["data"] = (object)[
            "title" => "Format Surat",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "data" => $data
        ];


        return $this->view("admin/format_surat/format_surat", $params);
    }

    public  function create()
    {
        // default value
        $data = (object)[
            "nama" => "",
            "konten" => "",
        ];
        $params["data"] = (object)[
            "title" => "Tambah Format Surat",
            "description" => "Kelola Format Surat dengan mudah",
            "action_form" => url("/admin/format-surat"),
            "data" => $data
        ];

        return $this->view("admin/format_surat/form", $params);
    }
    public  function store()
    {
        request()->validate([
            "nama" => "required",
            "konten" => "required"
        ]);
        try {
            $konten = request()->getRaw("konten");
            $nama = request("nama");

            $this->model->formatSurat->create([
                "nama" => $nama,
                "konten" => $konten
            ]);

            return redirect()->with("success", "Format Surat berhasil ditambahkan")->to("/admin/format-surat");
        } catch (\Throwable $th) {
            return redirect()->with("error", "Format Surat gagal ditambahkan")->withInput(request()->getAll())->back();
        }
    }

    public  function edit($id)
    {

        $formatSurat = $this->model->formatSurat->find($id);
        if (!$formatSurat) return show404();
        $data = (object)[
            "nama" => $formatSurat->nama ?? null,
            "konten" => $formatSurat->konten ?? null,
        ];

        $params["data"] = (object)[
            "title" => "Ubah Format Surat",
            "description" => "Kelola Format Surat dengan mudah",
            "action_form" => url("/admin/format-surat/$id"),
            "data" => $data
        ];


        return $this->view("admin/format_surat/form", $params);
    }


    public  function update($id)
    {
        request()->validate([
            "nama" => "required",
            "konten" => "required"
        ]);
        try {
            $konten = request()->getRaw("konten");
            $nama = request("nama");

            $this->model->formatSurat->where("id", "=", $id)->update([
                "nama" => $nama,
                "konten" => $konten
            ]);

            return redirect()->with("success", "Format Surat berhasil diubah")->to("/admin/format-surat");
        } catch (\Throwable $th) {
            return redirect()->with("error", "Format Surat gagal diubah")->withInput(request()->getAll())->back();
        }
    }


    public function delete($id)
    {

        try {
            $kk = $this->model->formatSurat->find($id);
            if (!$kk) {
                return response("Format Surat tidak ditemukan", 404);
            }

            $masyarakat = $this->model->masyarakat->where("no_kk", "=", $kk->no_kk)->get();
            foreach ($masyarakat as $msy) {
                $this->model->user->where("nik", "=", $msy->nik)->delete();
                $this->model->masyarakat->where("nik", "=", $msy->nik)->delete();
            }
            $fileUpload = new FileUploader();
            $fileUpload->delete(storagePath("private", "/kartu_keluarga/" . $kk->kk_file));

            $this->model->kartuKeluarga->where("no_kk", "=", $id)->delete();
            return response("Format Surat berhasil dihapus", 200);
        } catch (\Throwable $th) {
            return response("Format Surat gagal dihapus", 500);

            // return redirect()->with("error", "Kartu keluarga gagal dihapus")->to("/admin/kartu-keluarga");
        }
    }


    public function import()
    {
        $file = request("file");
        try {
            $kkImport = new KartuKeluargaImport();
            $data =  $kkImport->import($file);
            return redirect()->with("success", "Kartu keluarga berhasil diimport")->back();
        } catch (\Throwable $th) {
            return redirect()->with("error", "Kartu keluarga gagal diimport")->back();
        }
    }
}
