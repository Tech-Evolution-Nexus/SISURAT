<?php

namespace app\controllers;

use app\interface\Controller;
use app\models\KartuKeluargaModel;

class KartuKeluargaController extends Controller
{

    public  function index()
    {
        $model  = new KartuKeluargaModel();

        $data = $model->all();
        $params["data"] = (object)[
            "title" => "Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "data" => $data
        ];



        return $this->view("admin/kartu_keluarga/kartu_keluarga", $params);
    }
    public  function create()
    {
        $model  = new KartuKeluargaModel();
        $data = (object)[
            "no_kk" => "",
            "kepala_keluarga" => "",
            "alamat" => "",
            "rt" => "",
            "rw" => "",
        ];
        $params["data"] = (object)[
            "title" => "Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "data" => $data
        ];



        return $this->view("admin/kartu_keluarga/form", $params);
    }
}
