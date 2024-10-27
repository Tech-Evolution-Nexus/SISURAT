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
        $this->model =  (object)[];
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
    }
    public  function index()
    {
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.id,nama_lengkap,no_kk,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.id", "masyarakat.id_kk")
            ->orderBy("kartu_keluarga.id", "desc")
            ->get();

        $params["data"] = (object)[
            "title" => "Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "data" => $data
        ];

        return $this->view("admin/kartu_keluarga/kartu_keluarga", $params);
    }
    public  function create()
    {
        // default value
        $data = (object)[
            "id" => "",
            "no_kk" => "",
            "tanggal_kk" => "",
            "nik" => "",
            "nama" => "",
            "alamat" => "",
            "rt" => "",
            "rw" => "",
            "kode_pos" => "68281",
            "kelurahan" => "Bataan Bunduh",
            "kecamatan" => "Tenggarang",
            "kabupaten" => "Bondowoso",
            "provinsi" => "Jawa Timur",
        ];
        $params["data"] = (object)[
            "title" => "Tambah Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "action_form" => "/admin/kartu-keluarga",
            "data" => $data
        ];

        return $this->view("admin/kartu_keluarga/form", $params);
    }
    public  function store()
    {
        $noKK = request("no_kk");
        $tanggalKK = request("tanggal_kk");
        $nama = request("nama");
        $nik = request("nik");
        $alamat = request("alamat");
        $rt = request("rt");
        $rw = request("rw");
        $kelurahan = request("kelurahan");
        $kode_pos = request("kode_pos");
        $kabupaten = request("kabupaten");
        $provinsi = request("provinsi");
        $kecamatan = request("kecamatan");

        $check = $this->model->kartuKeluarga
            ->select("no_kk,nik")
            ->join("masyarakat", "kartu_keluarga.id", "masyarakat.id_kk")
            ->where("no_kk", "=", $noKK)
            ->where("nik", "=", $nik)
            ->first();
        if ($check) return redirect("/admin/kartu-keluarga/create");
        //insert ke kartu keluarga

        $idKK =  $this->model->kartuKeluarga->create(["no_kk" => $noKK, "alamat" => $alamat, "rt" => $rt, "rw" => $rw, "kode_pos" => $kode_pos, "kelurahan" => $kelurahan, "kecamatan" => $kecamatan, "kabupaten" => $kabupaten, "provinsi" => $provinsi, "kk_tgl" => $tanggalKK]);

        $this->model->masyarakat->create([
            "nik" => $nik,
            "nama_lengkap" => $nama,
            "jenis_kelamin" => "laki-laki",
            "tempat_lahir" => "-",
            "tgl_lahir" => date("Y-m-d"),
            "agama" => "-",
            "pendidikan" => "-",
            "pekerjaan" => "-",
            "golongan_darah" => "-",
            "status_keluarga" => "KK",
            "status_perkawinan" => "-",
            "kewarganegaraan" => "-",
            "no_paspor" => "-",
            "no_kitap" => "-",
            "nama_ayah" => "-",
            "nama_ibu" => "-",
            "id_kk" => $idKK
        ]);

        return redirect("/admin/kartu-keluarga");
    }

    public  function edit($id)
    {
        $kartuKeluarga = $this->model->kartuKeluarga
            ->select("kartu_keluarga.id,nama_lengkap,no_kk,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.id", "masyarakat.id_kk")
            ->where("kartu_keluarga.id", "=", $id)
            ->first();

        if (!$kartuKeluarga) return show404();
        $data = (object)[
            "id" => $kartuKeluarga->id ?? null,
            "no_kk" => $kartuKeluarga->no_kk ?? null,
            "tanggal_kk" => $kartuKeluarga->kk_tgl ?? null,
            "nik" => $kartuKeluarga->nik ?? null,
            "nama" => $kartuKeluarga->nama_lengkap ?? null,
            "alamat" => $kartuKeluarga->alamat ?? null,
            "rt" => $kartuKeluarga->rt ?? null,
            "rw" => $kartuKeluarga->rw ?? null,
            "kode_pos" => $kartuKeluarga->kode_pos ?? null,
            "kelurahan" => $kartuKeluarga->kelurahan ?? null,
            "kecamatan" => $kartuKeluarga->kecamatan ?? null,
            "kabupaten" => $kartuKeluarga->kabupaten ?? null,
            "provinsi" => $kartuKeluarga->provinsi ?? null,
        ];
        $params["data"] = (object)[
            "title" => "Ubah Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "action_form" => "/admin/kartu-keluarga/$id",
            "data" => $data
        ];

        return $this->view("admin/kartu_keluarga/form", $params);
    }


    public  function update($id)
    {
        $noKK = request("no_kk");
        $tanggalKK = request("tanggal_kk");
        $nama = request("nama");
        $nik = request("nik");
        $alamat = request("alamat");
        $rt = request("rt");
        $rw = request("rw");
        $kelurahan = request("kelurahan");
        $kode_pos = request("kode_pos");
        $kabupaten = request("kabupaten");
        $provinsi = request("provinsi");
        $kecamatan = request("kecamatan");

        $check = $this->model->kartuKeluarga
            ->select("no_kk,nik")
            ->join("masyarakat", "kartu_keluarga.id", "masyarakat.id_kk")
            ->where("no_kk", "=", $noKK)
            ->where("nik", "=", $nik)
            ->where("kartu_keluarga.id", "<>", $id)
            ->first();
        if ($check) return redirect("/admin/kartu-keluarga/create");
        //insert ke kartu keluarga

        // $dataKK =  $this->model->kartuKeluarga->update($id, ["no_kk" => $noKK, "alamat" => $alamat, "rt" => $rt, "rw" => $rw, "kode_pos" => $kode_pos, "kelurahan" => $kelurahan, "kecamatan" => $kecamatan, "kabupaten" => $kabupaten, "provinsi" => $provinsi, "kk_tgl" => $tanggalKK]);

        $idMasyarakat = $this->model->kartuKeluarga
            ->where("status_keluarga", "=", "KK")
            ->where("id_kk", "=", $id)
            ->first()->id;
        $this->model->masyarakat->update($idMasyarakat, [
            "nik" => $nik,
            "nama_lengkap" => $nama,
        ]);

        return redirect("/admin/kartu-keluarga");
    }
}
