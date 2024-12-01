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
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" =>[]], 400);
        }
    }
    public function dadashboardrt($nik)
    {
        $data = $this->model->MasyarakatModel
            ->join("users", "users.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("users.nik", "=", $nik)->first();
        if($data->role=="rt"){
            $countmasuk = $this->model->psurat
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("kartu_keluarga.rt", "=", $data->rt)
            ->where("kartu_keluarga.rw", "=", $data->rw);

        if ($data->role == "rt") {
            $countmasuk = $countmasuk->where("pengajuan_surat.status", "=", "pending")->count();
        } else {
            $countmasuk = $countmasuk->where("pengajuan_surat.status", "=", "di_terima_rt")->count();
        }

        $countselesai = $this->model->psurat
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("kartu_keluarga.rt", "=", $data->rt)
            ->where("kartu_keluarga.rw", "=", $data->rw);
        }else{
            $countmasuk = $this->model->psurat
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
        
            ->where("kartu_keluarga.rw", "=", $data->rw);

        if ($data->role == "rt") {
            $countmasuk = $countmasuk->where("pengajuan_surat.status", "=", "pending")->count();
        } else {
            $countmasuk = $countmasuk->where("pengajuan_surat.status", "=", "di_terima_rt")->count();
        }

        $countselesai = $this->model->psurat
            ->join("masyarakat", "masyarakat.nik", "pengajuan_surat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("kartu_keluarga.rw", "=", $data->rw);
        }
       

        if ($data->role == "rt") {
            $countselesai = $countselesai->whereIn("pengajuan_surat.status", ["di_terima_rt", "di_tolak_rt", "selesai"])->count();
        } else {
            $countselesai = $countselesai->whereIn("pengajuan_surat.status", ["di_terima_rw", "di_tolak_rw", "selesai"])->count();
        }
        // $countmasuk = $countmasuk->count();
        if ($countmasuk) {
            return response(["status" => true, "message" => "Berhasil Ditemukan", "data" => ["masuk" => $countmasuk, "selesai" => $countselesai]], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Ditemukan", "data" => []], 200);
        }
    }
}
