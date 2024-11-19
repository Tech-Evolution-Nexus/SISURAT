<?php

namespace app\controllers\api;

use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranPengajuanModel;
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
        $this->model->lampiranpengajuanModel = new LampiranPengajuanModel();
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
        $data2 = $this->model->lampiransurat->select("id_surat", "lampiran.id", "nama_lampiran", "image")
            ->join("lampiran", "lampiran.id", "id_lampiran")->join("surat", "surat.id", "id_surat")->where("id_surat", "=", $idsurat)->get();;
        return response(["data" => ["msg" => "ad", "biodata" => $data, "datalampiran" => $data2]], 200);
    }
    public function detailhistory($idpengajuan)
    {
        $mas = $this->model->psurat->select()->where("id", "=", $idpengajuan)->first();
        // return response( $mas, 200);
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")->where("nik", "=", $mas->nik)
            ->get();
        $data2 = $this->model->lampiranpengajuanModel->select("lampiran.id", "lampiran.nama_lampiran", "url")
            ->join("lampiran", "lampiran.id", "id_lampiran")->where("id_pengajuan", "=", $idpengajuan)->get();
        return response(["data" => ["msg" => "ad", "biodata" => $data, "datahistori" => $data2]], 200);
    }
    private function getDataByStatus($statusFilter)
    {

        if (!is_array($statusFilter)) {
            $statusFilter = [$statusFilter];
        }
        $placeholders = implode(',', array_fill(0, count($statusFilter), '?'));
        return $placeholders;
    }
    public function getPengajuan($nik, $status)
    {
        // Buat filter status
        $statusFilter = [];
        if ($status) {
            $statusFilter = is_array($status) ? $status : explode('|', $status);
        }

        // Query data
        $data = $this->model->psurat->select(
            "pengajuan_surat.id",
            "nomor_surat",
            "no_pengantar",
            "status",
            "keterangan",
            "keterangan_ditolak",
            "file_pdf",
            "pengantar_rt",
            "pengantar_rw",
            "nik",
            "kode_kelurahan",
            "nomor_surat_tambahan",
            "pengajuan_surat.created_at",
            "pengajuan_surat.updated_at",
            "id_surat",
            "nama_surat",
            "image"
        )->join("surat", "surat.id", "=", "id_surat")->where("nik", "=", $nik);

        if (!empty($statusFilter)) {
            $data->whereIn('status', $statusFilter);
        }

        $result = $data->get();

        // Kembalikan respons
        return response([
            "data" => [
                "msg" => "Data retrieved successfully",
                "datariwayat" => $result
            ]
        ], 200);
    }

    public function getListPengajuan($nik, $status)
    {
        $user = $this->model->masyarakat
            ->select("rw,rt,role")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("masyarakat.nik", "=", $nik)
            ->whereIn("role", ["rw", "rt"])
            ->first();
        if ($user->role != "rw" && $user->role != "rt") {
            return response(["message" => "Anda tidak memiliki akses "], 404);
        }
        $statusAwal = $user->role == "rw" ? "di_terima_rt" : "pending";

        //mengambil data yang menunggu persetujuan berdasarkan status
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
        return response([
            "status" => "success",
            "message" => null,
            "data" => [
                "dataPengajuan" => $status === "pending" ? $data1 : $data2
            ]
        ], 200);
    }


    public function getDetailPengajuan($id_pengajuan)
    {
        $surat = $this->model->psurat
            ->select("nama_lengkap,nama_surat,pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,rw,rt")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("surat.id", "=", $id_pengajuan)
            ->first();
        $lampiran = $this->model->lampiranpengajuan
            ->select("nama_lampiran,url")
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->where("id_pengajuan", "=", $id_pengajuan)
            ->get();
        if (!$surat) {
            return response(["message" => "Surat tidak ditemukan "], 404);
        }

        $surat->lampiran = $lampiran;

        return response([
            "status" => "success",
            "message" => null,
            "data" => [
                "dataPengajuan" => $surat
            ]
        ], 200);
    }
}
