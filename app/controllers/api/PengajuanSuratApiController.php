<?php

namespace app\controllers\api;

use app\models\BeritaModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranPengajuanModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use app\models\UserModel;
use app\services\Database;
use PDO;
use Exception;
use FileUploader;

class PengajuanSuratApiController
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->pengajuansurModel = new PengajuanSuratModel();
        $this->model->lampiranpengajuanModel = new LampiranPengajuanModel();
        $this->model->lampiransuratModel = new LampiranSuratModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->user = new UserModel();



    }
    public function sendsurmas()
    {

        // $jsonData = json_decode(file_get_contents("php://input"), true);
        // if (!$jsonData) {
        //     return response(["data"=>"d","msg"=>"gagal"], 200);

        // }
        // return response(["data"=>$_POST['lampiran_info'],"msg"=>"behasil"], 200);
        header("Access-Control-Allow-Origin: *");

        $nik = request("nik");
        $idsurat = request("idsurat");
        $img = request("images");
        $keterangan = request("keterangan");
        $datalampiran = $this->model->lampiransuratModel->where("id_surat","=",$idsurat)->get();
        $data = $this->model->pengajuansurModel->create([
            "nik"=>$nik,
            "id_surat"=>$idsurat,
            "keterangan"=>$keterangan,
            "status"=>"pendding",
        ]);
    
        foreach ($img['name'] as $key => $tmp_name) {
          
            $fileName = $img['name'][$key];
            $fileTmpName = $img['tmp_name'][$key];
            $fileExt = pathinfo($fileName , PATHINFO_EXTENSION);
            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $nameFile  = uniqid() . "." . $fileExt;
            $this->model->lampiranpengajuanModel->create([
                'id_pengajuan' => $data,
                'id_lampiran' => $datalampiran[$key]->id_lampiran,
                'url'=>$nameFile
            ]);
            $uploader = new FileUploader();
            $uploader->setFile( $fileTmpName);
            $uploader->setTarget(storagePath("private", "/masyarakat/" . $nameFile));
            $uploader->setAllowedFileTypes($allowedFileTypes);
            $uploadStatus = $uploader->upload();
            if ($uploadStatus !== true) {
                return response(["data"=>$uploadStatus,"msg"=>"gaga Menambahkan"], 200);
            }
        }
        $data = $this->model->masyarakat->select("nik,kartu_keluarga.rt")->join("kartu_keluarga","masyarakat.no_kk","kartu_keluarga.no_kk")->where("masyarakat.nik","=",$nik)->first();
        $data2 = $this->model->user->select("rt,role,fcm_token")->join("masyarakat","masyarakat.nik","users.nik")->join("kartu_keluarga","masyarakat.no_kk","kartu_keluarga.no_kk")->where("kartu_keluarga.rt","=",$data->rt)->where("users.role","=","rt")->first();
        if($data2){
            if($data2->fcm_token != null){
                pushnotifikasito($data2->fcm_token,"Ada Surat Baru Masuk","Silahkan Klik Untuk Melakukan Persetujuan");
            }
        }
        return response(["data"=>$idsurat,$keterangan,"msg"=>"Berhasil Menambahkan"], 200);
    }
}
