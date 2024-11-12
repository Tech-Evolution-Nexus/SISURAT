<?php

namespace app\controllers\api;

use app\models\BeritaModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use app\services\Database;
use PDO;
use Exception;

class BeritaApiController
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->beritaModel = new BeritaModel();
    }
    public function getBerita()
    {
        $data = $this->model->beritaModel->select()->get();
        return response(["data"=>["msg"=>"ad","databerita" => $data]], 200);
    }
    public function getdetailberita($id)
    {
        $data = $this->model->beritaModel->select()->where("id","=",$id)->get();
        return response(["data"=>["msg"=>"ad","databerita" => $data]], 200);
    }
}