<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\BeritaModel;
use app\models\LandingModel;

class LandingController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = (object)[];
        $this->model->landing = new LandingModel();
        $this->model->berita = new BeritaModel();
    }
    public function index()
    {
        $params["data"] = (object)[
            "title" => "Badean POS",
            "data" => $this->model->landing->first()
        ];
        return $this->view("landing", $params);
    }
    public function berita()
    {
        $data = $this->model->berita->orderBy("id", "desc")->get();
        $params["data"] = (object)[
            "title" => "Berita Badean Terkini",
            "berita" => $data,
            "landing" => $this->model->landing->first()

        ];
        return $this->view("berita", $params);
    }
    public function beritaDetail($id)
    {
        $data = $this->model->berita->find($id);
        $params["data"] = (object)[
            "title" => "Berita Badean Terkini",
            "berita" => $data,
            "landing" => $this->model->landing->first()


        ];
        return $this->view("beritaDetail", $params);
    }
}
