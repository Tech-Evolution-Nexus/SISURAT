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
        return response(["data"=>["msg"=>"ad","datakk" => $data]], 200);
    }
    public function getdatasurat(){
        $data = $this->model->suratModel->select()->get();
        return response(["data"=>["msg"=>"ad","datasurat" => $data]], 200);
    }
}
