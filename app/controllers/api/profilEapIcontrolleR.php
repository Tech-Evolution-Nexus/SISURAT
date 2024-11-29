<?php

namespace app\controllers\api;

use app\models\KartuKeluargaModel;
use app\models\UserModel;
use app\models\MasyarakatModel;
use PDO;
use Exception;

class profilEapIcontrolleR
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->userModel = new UserModel();
        $this->model->masyarakatModel = new MasyarakatModel();
        $this->model->KkModel = new KartuKeluargaModel();
    }

    public function getdatauser($nik){
        // $nik = request("nik");
        $data = $this->model->userModel
            ->select("users.nik,masyarakat.no_kk,nama_lengkap,alamat,rt,rw,kartu_keluarga.kode_pos,kelurahan,kecamatan")
            ->join("masyarakat", "users.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("users.nik", "=",$nik)
            ->get();
        $data = $this->model->masyarakatModel->select()->where("nik", "=", $nik)->get();
        if ($data) {    
            return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => []], 400);
        }
    }
}
