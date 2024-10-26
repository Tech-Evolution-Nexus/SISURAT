<?php

namespace app\controllers;

use app\interface\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;

class KartuKeluargaController extends Controller
{
    private $model;
    public function __construct()
    {
        dd(request()->getAll());
        $this->model =  (object)[];
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
    }
    public  function index()
    {
        $data = $this->model->kartuKeluarga->all();
        $params["data"] = (object)[
            "title" => "Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "data" => $data
        ];



        return $this->view("admin/kartu_keluarga/kartu_keluarga", $params);
    }
    public  function create()
    {

        $kepalaKeluarga = $this->model->masyarakat->getUnconnectedMasyarakatToKepalaKeluarga();
        // default value
        $data = (object)[
            "no_kk" => "",
            "kepala_keluarga" => "",
            "alamat" => "",
            "rt" => "",
            "rw" => "",
        ];
        $params["data"] = (object)[
            "title" => "Tambah Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "action_form" => "/admin/kartu-keluarga",
            "kepala_keluarga" => $kepalaKeluarga,
            "data" => $data
        ];



        return $this->view("admin/kartu_keluarga/form", $params);
    }
    public  function store()
    {

        $noKK = request("no_kk");
        $kepalaKeluarga = request("kepala_keluarga");
        $alamat = request("alamat");
        $rt = request("rt");
        $rw = request("rw");



        return redirect("/admin/kartu-keluarga");
    }

    public  function edit($id)
    {
        $kepalaKeluarga = $this->model->masyarakat->getUnconnectedMasyarakatToKepalaKeluarga();
        $kartuKeluarga = $this->model->kartuKeluarga->getById($id);
        $data = (object)[
            "no_kk" => $kartuKeluarga->no_kk,
            "kepala_keluarga" => $kartuKeluarga->id_masyarakat,
            "alamat" => $kartuKeluarga->alamat,
            "rt" => $kartuKeluarga->rt,
            "rw" => $kartuKeluarga->rw,
        ];
        $params["data"] = (object)[
            "title" => "Ubah Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "action_form" => "/admin/kartu-keluarga/$id",
            "kepala_keluarga" => $kepalaKeluarga,
            "data" => $data
        ];

        return $this->view("admin/kartu_keluarga/form", $params);
    }
}
