<?php

namespace app\controllers\api;

use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\services\Database;
use PDO;
use Exception;

class KkApiController
{
    private $masyarakatModel;
    public function __construct(){
$this->masyarakatModel = new MasyarakatModel();
    }
    public function getdatakk($nik){
$data = $this->masyarakatModel->get();
return response(["data"=> $data],200);
    }
}