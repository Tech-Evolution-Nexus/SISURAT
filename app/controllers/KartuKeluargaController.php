<?php

namespace app\controllers;

use app\interface\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;

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
        $model  = new MasyarakatModel();
        $kepalaKeluarga = $model->getUnconnectedMasyarakatToKepalaKeluarga();
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
        $model  = new MasyarakatModel();
        $model2  = new KartuKeluargaModel();
        $kepalaKeluarga = $model->getUnconnectedMasyarakatToKepalaKeluarga();
        $kartuKeluarga = $model2->getById($id);
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
