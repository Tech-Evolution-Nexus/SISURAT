<?php

namespace app\controllers;

use app\abstract\Controller;
use app\import\KartuKeluargaImport;
use app\models\FieldsModel;
use app\models\FormatSuratModel;
use app\models\JenisSuratModel;
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
        // $this->model->formatSurat = new FormatSuratModel();
        $this->model->surat = new JenisSuratModel();
        $this->model->fields = new FieldsModel();
    }
    public  function index()
    {

        $data = $this->model->surat->orderBy("id", "desc")->get();

        $params["data"] = (object)[
            "title" => "Format Surat",
            "description" => "Kelola Format Surat dengan mudah",
            "data" => $data
        ];


        return $this->view("admin/format_surat/format_surat", $params);
    }

    // public  function create()
    // {
    //     // default value
    //     $data = (object)[
    //         "nama" => "",
    //         "konten" => `<h2 style="text-align:center;"><strong>Surat Keterangan</strong></h2><p style="text-align:center;"><strong>No.</strong> <strong>{no_surat}</strong></p><p><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</strong>Yang bertanda tangan di bawah ini ketua RT {rt}, RW {rw}, Desa &nbsp;{desa} Kecamatan {kecamatan} Kabupaten {kabupaten} dengan ini menerangkan bahwa :</p><figure class="table"><table><tbody><tr><td>Nama</td><td>: {nama}</td></tr><tr><td>Tempat/ Tanggal lahir</td><td>: {tempat_lahir}/{tanggal_lahir}</td></tr><tr><td>Jenis Kelamin</td><td>: {jenis_kelamin}</td></tr><tr><td>Pekerjaan</td><td>: {pekerjaan}</td></tr><tr><td>Agama</td><td>: {agama}</td></tr><tr><td>Status perkawinan</td><td>: {status_perkawinan}</td></tr><tr><td>Kewarganegaraan</td><td>: {kewarganegaraan}</td></tr><tr><td>Alamat</td><td>: {alamat}</td></tr></tbody></table></figure><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Orang tersebut diatas, adalah benar-benar warga kami dan berdomisili di RT {rt}, RW {rw} Desa {desa} Kecamatan {kecamatan} Kabupaten {kabupaten} surat keterangan ini digunakan sebagai kelengkapan pengurusan perpindahan penduduk.</p><p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Demikian surat keterangan ini kami buat, untuk dapat dipergunakan sebagaimana semestinya.</p><p>&nbsp;</p><p>&nbsp;</p><p style="text-align:right;">{tanggal_pengajuan},Ketua RT {rt} RW {rt} &nbsp; &nbsp; &nbsp;&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">&nbsp;</p><p style="text-align:right;">{nama} &nbsp; &nbsp;</p>`,
    //     ];
    //     $params["data"] = (object)[
    //         "title" => "Tambah Format Surat",
    //         "description" => "Kelola Format Surat dengan mudah",
    //         "action_form" => url("/admin/format-surat"),
    //         "data" => $data
    //     ];

    //     return $this->view("admin/format_surat/form", $params);
    // }
    // public  function store()
    // {
    //     request()->validate([
    //         "nama" => "required",
    //         "konten" => "required"
    //     ]);
    //     try {
    //         $konten = request()->getRaw("konten");
    //         $nama = request("nama");

    //         $this->model->formatSurat->create([
    //             "nama" => $nama,
    //             "konten" => $konten
    //         ]);

    //         return redirect()->with("success", "Format Surat berhasil ditambahkan")->to("/admin/format-surat");
    //     } catch (\Throwable $th) {
    //         return redirect()->with("error", "Format Surat gagal ditambahkan")->withInput(request()->getAll())->back();
    //     }
    // }

    public  function edit($id)
    {
        $formatSurat = $this->model->surat->find($id);
        $fields = $this->model->fields->select("nama_field")->where("id_surat", "=", $id)->get();
        if (!$formatSurat) return show404();
        $data = (object)[
            "nama" => $formatSurat->nama_surat ?? null,
            "konten" => $formatSurat->format_surat ?? null,
        ];
        $data->fields = array_map(fn($e) => "{field_" . strtolower(str_replace(" ", "_", trim($e->nama_field)) . "}"), $fields);
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
            "konten" => "required"
        ]);
        try {
            $konten = request()->getRaw("konten");
            $this->model->surat->where("id", "=", $id)->update([
                "format_surat" => $konten
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
