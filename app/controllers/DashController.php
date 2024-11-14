<?php

namespace app\controllers;

use app\models\JenisSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use PHPMailer\PHPMailer\PHPMailer;
use app\models\UserModel;

use Exception;


class DashController
{
    public $model;
    // private $model;
    public function __construct()
    {
        $this->model = (object)[];
        $this->model->users = new UserModel();
        $this->model->jenisSurat = new JenisSuratModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->pengajuan = new PengajuanSuratModel();
    }
    public  function index()
    {
        $jenisSurat = $this->model->jenisSurat->get();
        $masyarakat = $this->model->masyarakat->get();
        $pengajuan = $this->model->pengajuan->get();
        $params["data"] = (object)[
            "title" => "Dashboard",
            "description" => "Selamat datang di dashboard admin",
            "jenis_surat" => count($jenisSurat),
            "masyarakat" => count($masyarakat),
            "pengajuan" => count($pengajuan),
        ];
        return view("admin/dashboard/dashboard", $params);
    }
}
