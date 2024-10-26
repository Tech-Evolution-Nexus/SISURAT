<?php

namespace app\controllers;

use app\interface\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\RT_RWModel;
use app\models\UserModel;

class RT_RWController extends Controller
{

    public  function indexRW()
    {
        $model  = new RT_RWModel();
        $model2  = new MasyarakatModel();

        $data = $model->all('rw');
        $masyarakat = $model2->masyarakatActive();
        $params["data"] = (object)[
            "title" => "RW",
            "description" => "Kelola Data ketua RW dengan mudah",
            "masyarakat" => $masyarakat,
            "data" => $data
        ];

        return $this->view("admin/rt-rw/rw", $params);
    }
    public  function ajaxMasyarakat($id)
    {
        $model  = new MasyarakatModel();
        $data  = $model->getMasyarakatId($id);
        return response($data, 200);
    }
    public  function ajaxRw($id)
    {
        $model  = new RT_RWModel();
        $data  = $model->getById($id, "rw");
        return response($data, 200);
    }


    public  function storeRW()
    {
        try {

            $model  = new RT_RWModel();
            $nik = request("nik");
            $idMasyarakat = request("id_masyarakat");

            $alamat = request("alamat");
            $rt = request("rt");
            $rw = request("rw");
            $noHp = request("no_hp");
            $password = request("password");

            $cekResult =  $model->cek("rw", $rw, $rt, $nik);

            if ($cekResult) {
                return;
            }

            $model2  = new UserModel();
            $data = [
                "email" => null,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "no_hp" => $noHp,
                "role" => "rw",
                "id_masyarakat" => $idMasyarakat,
                "created_at" => date("Y-m-d H:i")
            ];
            $model2->create($data);
            return redirect("/admin/master-rw");
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException($th);
        }
    }
    public  function updateRW($idmasyarakat)
    {
        try {
            $model  = new RT_RWModel();
            $nik = request("nik");
            $idMasyarakat = request("id_masyarakat");
            $alamat = request("alamat");
            $rt = request("rt");
            $rw = request("rw");
            $noHp = request("no_hp");
            $password = request("password");
            $cekResult =  $model->cek("rw", $rw, $rt, $nik);
            if ($cekResult) {
                return;
            }
            $model2  = new UserModel();
            $data = [
                "no_hp" => $noHp,
            ];
            $user = $model2->getByIdMasyarakat($idmasyarakat);

            if ($password !== null) $data["password"] = password_hash($password, PASSWORD_BCRYPT);
            $model2->update($user->id, $data);
            return redirect("/admin/master-rw");
        } catch (\Throwable $th) {
            // var_dump($th);;
            die();
        }
    }
}
