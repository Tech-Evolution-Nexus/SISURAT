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
        if (!auth()->check()) {
            redirect("/login");
        }
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
            ->orderBy("pengajuan_surat.created_at", "desc")
            ->get();
        // dd($data);
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
        try {
            $status = request("status");
            $no_surat = request("no_surat");
            $no_surat_tambahan = request("no_surat_tambahan");
            $no_kelurahan = request("no_kelurahan");
            $data = [
                "status" => "selesai",
                "nomor_surat" => $no_surat,
                "nomor_surat_tambahan" => $no_surat_tambahan,
                "kode_kelurahan" => $no_kelurahan
            ];
            $this->model->pengajuan_surat->where("id", "=", $idPengajuan)->update($data);
            return redirect()->with("success", "Pengajuan surat berhasil disetujui")->back();
        } catch (\Throwable $th) {
            return redirect()->with("error", "Pengajuan surat gagal disetujui")->back();
        }
    }
}
