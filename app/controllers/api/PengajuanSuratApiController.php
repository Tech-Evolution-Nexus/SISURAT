<?php

namespace app\controllers\api;

use app\models\BeritaModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranPengajuanModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
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

    }
    public function sendsurmas()
    {

        // $jsonData = json_decode(file_get_contents("php://input"), true);
        // if (!$jsonData) {
        //     return response(["data"=>"d","msg"=>"gagal"], 200);

        // }
        // return response(["data"=>$_POST['lampiran_info'],"msg"=>"behasil"], 200);
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
            "kode_kelurahan"=>"123312"
        ]);

        foreach ($img['name'] as $key => $tmp_name) {
            $this->model->lampiranpengajuanModel->create([
                'id_pengajuan' => $data,
                'id_lampiran' => $datalampiran[$key]->id_lampiran,
                'url'=>$img['name'][$key]
            ]);
            $fileName = $img['name'][$key];
            $fileTmpName = $img['tmp_name'][$key];
            $fileExt = pathinfo($fileName , PATHINFO_EXTENSION);
            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $nameFile  = uniqid() . "." . $fileExt;
            $uploader = new FileUploader();
            $uploader->setFile( $fileTmpName);
            $uploader->setTarget(storagePath("private", "/masyarakat/" . $nameFile));
            $uploader->setAllowedFileTypes($allowedFileTypes);
            $uploadStatus = $uploader->upload();
            if ($uploadStatus !== true) {
                return response(["data"=>$uploadStatus,"msg"=>"gaga Menambahkan"], 200);
            }
        }
        return response(["data"=>$idsurat,$keterangan,"msg"=>"Berhasil Menambahkan"], 200);



        // $nokelurahan = request("nokelurahan");
        // $lampengajuan = request("lampiran_pengajuan");
        // $idpengajuan = request("id_pengajuan");
        // $idlampiran = request("id_lampiran");
        // $fileimg = request("fileimg");


     

       
        // if($data){
        //     return response(["data"=>["msg"=>"ad","databerita" => null]], 200);
        // }else{
        //     return response(["data"=>["msg"=>"ad","databerita" => null]], 400);
        // }
    }
}
