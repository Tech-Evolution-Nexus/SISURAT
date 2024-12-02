<?php

namespace app\controllers\api;

use app\models\FieldsModel;
use app\models\FieldValuesModel;
use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranPengajuanModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use app\services\Database;
use PDO;
use Exception;

class SuratApiController
{
    private $model;

    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->jsurat  = new JenisSuratModel();
        $this->model->lampiransurat  = new LampiranSuratModel();
        $this->model->lampiranpengajuanModel = new LampiranPengajuanModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->psurat = new PengajuanSuratModel();
        $this->model->FieldsModel = new FieldsModel();
        $this->model->FieldsValueModel = new FieldValuesModel();

    }
    public function getdata()
    {
        $data = $this->model->jsurat->limit(6)->get();
        return response(["data" => $data,], 200);
    }

    public function getdataall($limit)
    {
        if ($limit == "all") {
            $data = $this->model->jsurat->select()->orderBy("id", "DESC")->all();
        } else {
            $data = $this->model->jsurat->select()->limit(6)->orderBy("id", "DESC")->get();
        }
        if ($data) {
            return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => $data], 400);
        }
    }
    public function getform($nik, $idsurat)
    {
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")->where("nik", "=", $nik)
            ->first();
        if ($data) {
            $data2 = $this->model->lampiransurat->select("id_surat", "lampiran.id", "nama_lampiran")
                ->join("lampiran", "lampiran.id", "id_lampiran")->join("surat", "surat.id", "id_surat")->where("id_surat", "=", $idsurat)->get();
            $data3 = $this->model->FieldsModel->select("surat.id,fields.id_surat,nama_field,tipe,is_required")
                ->join("surat", "surat.id", "fields.id_surat")->where("id_surat", "=", $idsurat)->get();
            if ($data2) {
                return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => ["biodata" => $data, "datalampiran" => $data2, "datafield" => $data3]], 200);
            } else {
                return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => ["biodata" => [], "datalampiran" => []]], 400);
            }
        } else {
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" => ["biodata" => [], "datalampiran" => []]], 400);
        }
    }
    public function detailhistory($idpengajuan)
    {
        $mas = $this->model->psurat->select()->where("id", "=", $idpengajuan)->first();
        if($mas){
            $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")->where("nik", "=", $mas->nik)
            ->first();
        $data2 = $this->model->lampiranpengajuanModel->select("lampiran.id", "lampiran.nama_lampiran", "url")
            ->join("lampiran", "lampiran.id", "id_lampiran")->where("id_pengajuan", "=", $idpengajuan)->get();
        $data3 = $this->model->FieldsValueModel->select("field_values.id,fields.nama_field,field_values.value")
            ->join("fields", "field_values.id_field", "fields.id")->where("id_pengajuan", "=", $idpengajuan)->get();
        return response(["status" => true, "message" => "Berhasil Mengambil Data", "data" => ["biodata" => $data, "datalampiran" => $data2, "datafield" => $data3]], 200);
        }else{
            return response(["status" => false, "message" => "Gagal Mengambil Data", "data" =>[]], 200);

        }
        // return response( $mas, 200);
       
    }
    private function getDataByStatus($statusFilter)
    {

        if (!is_array($statusFilter)) {
            $statusFilter = [$statusFilter];
        }
        $placeholders = implode(',', array_fill(0, count($statusFilter), '?'));
        return $placeholders;
    }
    public function dibatalkan()
    {
        $jsonData = json_decode(file_get_contents("php://input"), true);
        $dataa = ["status" => "dibatalkan"];
        $data = $this->model->psurat->where("id", "=", $jsonData)->update($dataa);
        if ($data) {
            return response(["status" => true, "message" => "Berhasil Di Batalkan", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Gagal Di Batalkan", "data" => $data], 200);
        }
    }
}
