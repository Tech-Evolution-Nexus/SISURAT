<?php

namespace app\controllers\api;

use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\services\Database;
use PDO;
use Exception;

class SuratApiController
{
    private $model;

    public function __construct(){
        $this->model =  (object)[];
        $this->model->jsurat  = new JenisSuratModel();
        $this->model->lampiransurat  = new LampiranSuratModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();

    }
    public function getdata(){
        $data =$this->model->jsurat->select("nama_surat","image")->limit(6)->all();
        return response(["data"=>$data],200);
    }
    public function getdataall(){
        $data =$this->model->jsurat->select("nama_surat","image")->all();
        return response(["data"=>$data],200);
    }
    public function getlampiran($id){
        $data =$this->model->lampiransurat->select("id_surat","lampiran.id","nama_lampiran")
        ->join("lampiran","lampiran.id","id_lampiran")->where("id_surat","=",$id)->get();;
        return response(["data"=>$data],200);
    }
    public function getform($nik,$idsurat){
        $data = $this->model->kartuKeluarga
        ->select("kartu_keluarga.id,nama_lengkap,no_kk,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
        ->join("masyarakat", "kartu_keluarga.id", "masyarakat.id_kk")->where("nik","=",$nik)
        ->get();
        $data2 =$this->model->lampiransurat->select("id_surat","lampiran.id","nama_lampiran")
        ->join("lampiran","lampiran.id","id_lampiran")->where("id_surat","=",$idsurat)->get();;
        return response(["biodata"=>$data,"data"=>$data2],200);
    }
}