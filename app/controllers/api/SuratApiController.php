<?php

namespace app\controllers\api;

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
    }
    public function getdata()
    {
        $data = $this->model->jsurat->select()->limit(6)->all();
        return response(["data" => $data,], 200);
    }

    public function getdataall()
    {
        $data = $this->model->jsurat->select()->all();
        return response(["data" => ["msg" => "ad", "datalampiran" => $data]], 200);
    }
    public function getform($nik, $idsurat)
    {
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")->where("nik", "=", $nik)
            ->get();
        $data2 = $this->model->lampiransurat->select("id_surat", "lampiran.id", "nama_lampiran", "image")
            ->join("lampiran", "lampiran.id", "id_lampiran")->join("surat", "surat.id", "id_surat")->where("id_surat", "=", $idsurat)->get();;
        return response(["data" => ["msg" => "ad", "biodata" => $data, "datalampiran" => $data2]], 200);
    }
    public function detailhistory($idpengajuan)
    {
        $mas = $this->model->psurat->select()->where("id", "=", $idpengajuan)->first();
        // return response( $mas, 200);
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")->where("nik", "=", $mas->nik)
            ->get();
        $data2 = $this->model->lampiranpengajuanModel->select("lampiran.id", "lampiran.nama_lampiran", "url")
            ->join("lampiran", "lampiran.id", "id_lampiran")->where("id_pengajuan", "=", $idpengajuan)->get();
        return response(["data" => ["msg" => "ad", "biodata" => $data, "datahistori" => $data2]], 200);
    }
    private function getDataByStatus($statusFilter)
    {

        if (!is_array($statusFilter)) {
            $statusFilter = [$statusFilter];
        }
        $placeholders = implode(',', array_fill(0, count($statusFilter), '?'));
        return $placeholders;
    }
}
