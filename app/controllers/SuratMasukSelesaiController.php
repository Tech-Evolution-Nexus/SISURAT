<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use FileUploader;

class SuratMasukSelesaiController extends Controller
{
    private $model;
    function __construct()
    {
        $this->model =  (object)[];
        $this->model->psurat  = new PengajuanSuratModel();
    }
    public function  index()
    {
        $data = $this->model->psurat->select("nomor_surat", "nik", "nama_lengkap", "nama_surat", "pengajuan_surat.created_at", "status", "no_hp")->join("masyarakat", "masyarakat.id", "pengajuan_surat.id_masyarakat")->join("surat", "surat.id", "pengajuan_surat.id_surat")->join("users", "users.id_masyarakat", "pengajuan_surat.id_masyarakat")->get();

        $params["data"] = (object)[
            "title" => "Jenis Surat",
            "description" => "Kelola Jenis dengan mudah",
            "data" => $data,

        ];
        return view('admin/surat_masuk_selesai/surat_selesai', $params);
    }
    public function  getdata($id)
    {
        $biodata = $this->model->psurat->select(
            "nomor_surat as nomor_surat",
            "nama_surat as nama_surat",
            "nik as nik",
            "nama_lengkap as nama_lengkap",
            "tempat_lahir as tempat_lahir",
            "tgl_lahir as tanggal_lahir",
            "jenis_kelamin as jenis_kelamin",
            "kewarganegaraan as kewarganegaraan",
            "agama as agama",
            "status_perkawinan as status_perkawinan",
            "pekerjaan as pekerjaan",
            "pengajuan_surat.created_at as tanggal_pengajuan"
        )
            ->join("masyarakat", "masyarakat.id", "pengajuan_surat.id_masyarakat")
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->where("nomor_surat", "=", $id)->get();
        $datasurat = $this->model->psurat->select(
            "lampiran.nama_lampiran",
            "url"
        )
            ->join("surat", "surat.id", "pengajuan_surat.id_surat")
            ->join("lampiran_pengajuan", "lampiran_pengajuan.id_pengajuan", "pengajuan_surat.id")
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->where("nomor_surat", "=", $id)->get();
        $params = [
            "biodata" => $biodata,
            "datasurat" => $datasurat,
        ];
        return response($params, 200);
    }
}
