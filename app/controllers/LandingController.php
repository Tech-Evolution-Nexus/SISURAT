<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\LandingModel;

class LandingController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model = (object)[];
        $this->model->landing = new LandingModel();
    }
    public function index()
    {
        $params["data"] = (object)[
            "title" => "Badean POS",
            "data" => $this->model->landing->first()
        ];
        return $this->view("landing", $params);
    }
}
