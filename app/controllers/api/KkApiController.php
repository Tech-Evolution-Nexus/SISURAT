<?php

namespace app\controllers\api;

use app\models\JenisSuratModel;
use app\models\MasyarakatModel;
use PDO;
use Exception;

class KkApiController
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->masyarakatModel = new MasyarakatModel();
        $this->model->suratModel = new JenisSuratModel();

    }
    public function getdatakk($nokk){
        $data = $this->model->masyarakatModel->select()->where("no_kk", "=", $nokk)->get();
        if ($data) {    
            return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => []], 400);
        }
    }
}
