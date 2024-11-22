<?php

namespace app\controllers\api;

use app\models\BeritaModel;
use PDO;
use Exception;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class BeritaApiController
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->beritaModel = new BeritaModel();
    }
    public function getBerita($limit)
    {
        if($limit == "all"){
            $data = $this->model->beritaModel->select()->orderBy("id","DESC")->get();
        }else{
            $data = $this->model->beritaModel->select()->limit(8)->orderBy("id","DESC")->get();
        }
        if ($data) {
            return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => []], 400);
        }
    }
    public function getdetailberita($id)
    {
        $data = $this->model->beritaModel->select()->where("id", "=", $id)->first();
        if ($data) {
            return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => []], 400);
        }
    }
}
