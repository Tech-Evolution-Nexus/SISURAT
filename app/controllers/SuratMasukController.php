<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\LampiranPengajuanModel;
use app\models\PengajuanSuratModel;

class SuratMasukController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->pengajuan_surat = new PengajuanSuratModel();
        $this->model->lampiran = new LampiranPengajuanModel();
    }
    public function index()
    {
        $data = $this->model->pengajuan_surat
            ->select("pengajuan_surat.nik,surat.id,nama_lengkap,nama_surat,pengajuan_surat.created_at,status")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->where("status", "=", "di_terima_rw")
            ->orderBy("created_at", "desc")
            ->get();
        $params["data"] = (object)[
            "title" => "Surat Masuk",
            "description" => "Kelola surat masuk dengan mudah",
            "data" => $data,
        ];
        return view("admin/surat_masuk_selesai/surat_masuk", $params);
    }

    public function ajaxPengajuan($idPengajuan)
    {
        $data = $this->model->pengajuan_surat
            ->select("pengajuan_surat.nik,surat.id,nama_lengkap,nama_surat,surat.created_at as tanggal_pengajuan,pengajuan_surat.nomor_surat,no_pengantar,jenis_kelamin,kewarganegaraan,agama,pekerjaan,alamat,tempat_lahir,tgl_lahir,status,nomor_surat_tambahan,kode_kelurahan")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->where("status", "=", "di_terima_rw")
            ->where("surat.id", "=", $idPengajuan)
            ->first();

        $lampiran = $this->model->lampiran
            ->select("nama_lampiran,url")
            ->where("id_pengajuan", "=", $idPengajuan)
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->get();

        $data->tgl_lahir = formatDate($data->tgl_lahir);
        $data->tanggal_pengajuan = formatDate($data->tanggal_pengajuan);
        $data->status = formatStatusPengajuan($data->status);
        $data->lampiran = $lampiran;

        return response($data, 200);
    }


    public function updateStatus($idPengajuan)
    {
        $status = request("status");
        return redirect()->with("success", "Pengajuan surat berhasil disetujui");
    }
}
