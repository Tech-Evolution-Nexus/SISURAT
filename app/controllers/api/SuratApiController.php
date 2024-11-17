<?php

namespace app\controllers\api;

use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use app\services\Database;
use PDO;
use Exception;

class SuratApiController
{
    private $model;

    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->jsurat  = new JenisSuratModel();
        $this->model->lampiransurat  = new LampiranSuratModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->psurat = new PengajuanSuratModel();
    }
    public function getdata()
    {
        $data = $this->model->jsurat->select()->limit(6)->all();
        return response(["data" => $data,], 200);
    }

    public function getdataall()
    {
        $data = $this->model->jsurat->select()->all();
        return response(["data" => ["msg" => "ad", "datalampiran" => $data]], 200);
    }
    public function getform($nik, $idsurat)
    {
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")->where("nik", "=", $nik)
            ->get();
        $data2 = $this->model->lampiransurat->select("id_surat", "lampiran.id", "nama_lampiran")
            ->join("lampiran", "lampiran.id", "id_lampiran")->where("id_surat", "=", $idsurat)->get();;
        return response(["data" => ["msg" => "ad", "biodata" => $data, "datalampiran" => $data2]], 200);
    }
    public function getPengajuan($nik, $status)
    {
        $data = $this->model->psurat->select()->where("nik", "=", $nik)->where("status", "=", $status)->get();
        return response(["data" => ["msg" => "ad", "datariwayat" => $data]], 200);
    }
    public function getListPengajuan($nik)
    {

        $user = $this->model->masyarakat
            ->select("rw,rt,role")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("masyarakat.nik", "=", $nik)
            ->first();
        if ($user->role != "rw" && $user->role != "rt") {
            return response(["message" => "Anda tidak memiliki akses "], 404);
        }
        $statusAwal = $user->role == "rw" ? "di_terima_rt" : "pending";
        $statusAkhir = $user->role == "rw" ? "di_terima_rw" : "pending";
        $data1 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("rw", "=", $user->rw)
            ->where("rt", "=", $user->rt)
            ->where("status", "=", $statusAwal)
            ->orderBy("pengajuan_surat.created_at", "desc")
            ->get();

        $data2 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap,rw,rt")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("rw", "=", $user->rw)
            ->where("rt", "=", $user->rt)
            ->orderBy("pengajuan_surat.created_at", "desc");

        if ($user->role === "rw") {
            $data2->where("status", "<>", "pending");
            $data2->where("status", "<>", "di_terima_rt");
        } else {
            $data2->where("status", "<>", "pending");
        }
        $data2 =  $data2->get();
        return response(["data" => [
            "msg" => "test",
            "totalData" => count($data1),
            "datapengajuanpending" => $data1,
            "datapengajuanselesai" => $data2
        ]], 200);
    }
}
