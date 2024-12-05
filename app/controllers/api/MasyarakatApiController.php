<?php

namespace app\controllers\api;

use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use app\models\UserModel;
use Exception;


class MasyarakatApiController
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->KartuKeluargaModel = new KartuKeluargaModel();
        $this->model->MasyarakatModel = new MasyarakatModel();
        $this->model->UsersModel = new UserModel();
        $this->model->psurat = new PengajuanSuratModel();
    }
    public function getverifmasyarakat()
    {
        $data = $this->model->UsersModel->join("masyarakat", "users.nik", "masyarakat.nik")->where("status", "=", 0)->get();
        if (!$data) {
            return response(["status" => false, "message" => "Data Verifikasi Kosong", "data" => []], 404);
        }
        return response(["status" => true, "message" => "Berhasil Mendapatkan Data", "data" => $data], 200);
    }
    public function accverifmasyarakat()
    {
        $nik = request("nik");
        $data = $this->model->UsersModel->where("nik", "=", $nik)->where("status", "=", 0)->first();
        if ($data && $this->model->UsersModel->where("nik", "=", $nik)->update(["status" => 1])) {
            return response(["status" => true, "message" => "Data Berhasil Ditolak", "data" => []], 200);
        }
        return response(["status" => false, "message" => "Data Gagal Ditolak", "data" => []], 200);
    }
    public function tolakverifmasyarakat()
    {
        $nik = request("nik");
        $users = $this->model->UsersModel->where("nik", "=", $nik)->where("status", "=", 0)->first();
        if (!$users) {
            return response(["status" => false, "message" => "Data Gagal Ditolak", "data" => []], 200);
        }

        $datamasyarakat = $this->model->MasyarakatModel->where("nik", "=", $nik)->first();

        if (!$datamasyarakat) {
            return response(["status" => false, "message" => "Data Gagal Ditolak", "data" => []], 200);
        }

        $count = $this->model->MasyarakatModel->where("no_kk", "=", $datamasyarakat->no_kk)->count();
        $this->model->UsersModel->where("nik", "=", $nik)->delete();
        $this->model->MasyarakatModel->where("nik", "=", $nik)->delete();

        if ($count <= 1) {
            $this->model->KartuKeluargaModel->where("no_kk", "=", $datamasyarakat->no_kk)->delete();
        }

        return response(["status" => true, "message" => "Data Berhasil Ditolak", "data" => []], 200);
    }
    public function detailprofilever($nik)
    {
        $data = $this->model->KartuKeluargaModel
            ->select("kartu_keluarga.no_kk,nama_lengkap,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi,kk_file")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("nik", "=", $nik)
            ->first();
        if ($data) {
            return response(["status" => true, "message" => "Berhasil Mengambil Data", "data" =>  $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => []], 400);
        }
    }
    public function dadashboardrt($nik)
    {
        $user = $this->model->MasyarakatModel
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
        $data1 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap,surat.image")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("status", "=", $statusAwal)
            ->orderBy("pengajuan_surat.updated_at", "desc");

        if ($user->role === "rw") {
            $data1->where("rw", "=", $user->rw);
        } else {
            $data1->where("rw", "=", $user->rw);
            $data1->where("rt", "=", $user->rt);
        }
        $data1 = $data1->count();
        $data2 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap,rw,rt,surat.image")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->orderBy("pengajuan_surat.updated_at", "desc");

        if ($user->role === "rw") {
            $data2->where("rw", "=", $user->rw);
            $data2->where("status", "<>", "pending");
            $data2->where("status", "<>", "di_terima_rt");
        } else {
            $data2->where("rw", "=", $user->rw);
            $data2->where("rt", "=", $user->rt);
            $data2->where("status", "<>", "pending");
        }
        $data2->where("status", "<>", "dibatalkan");
        $data2 =  $data2->count();
        return response([
            "status" => true,
            "message" => null,
            "data" => [
                "masuk" => $data1,
                "selesai" => $data2
            ]
        ], 200);
    }
}
