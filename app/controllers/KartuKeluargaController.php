<?php

namespace app\controllers;

use app\abstract\Controller;
use app\abstract\Model;
use app\import\KartuKeluargaImport;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\UserModel;
use FileUploader;

class KartuKeluargaController extends Controller
{
    private $model;
    public function __construct()
    {
        if (!auth()->check()) {
            redirect("/login");
        }

        $this->model =  (object)[];
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->user = new UserModel();
    }
    public  function index()
    {
        $data = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("status_keluarga", "=", "KK")
            ->orderBy("kartu_keluarga.created_at", "desc")
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
            "no_kk" => "",
            "tanggal_kk" => "",
            "nik" => "",
            "nama" => "",
            "alamat" => "",
            "rt" => "",
            "rw" => "",
            "foto_kartu_keluarga" => "",
            "kode_pos" => "68281",
            "kelurahan" => "Bataan Bunduh",
            "kecamatan" => "Tenggarang",
            "kabupaten" => "Bondowoso",
            "provinsi" => "Jawa Timur",
        ];
        $params["data"] = (object)[
            "title" => "Tambah Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "action_form" => url("/admin/kartu-keluarga"),
            "data" => $data
        ];

        return $this->view("admin/kartu_keluarga/form", $params);
    }
    public  function store()
    {
        request()->validate([
            "no_kk" => "required",
            "tanggal_kk" => "required",
            "nama" => "required|min:3|max:50",
            "nik" => "required|numeric|min:16",
            "alamat" => "required|max:255",
            "rt" => "required|numeric",
            "rw" => "required|numeric",
            "kelurahan" => "required|max:100",
            "kode_pos" => "required|numeric",
            "kabupaten" => "required|max:100",
            "provinsi" => "required|max:100",
            "kecamatan" => "required|max:100"
        ]);
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
        $foto_kartu_keluarga = request("foto_kartu_keluarga");



        $check = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nik")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("kartu_keluarga.no_kk", "=", $noKK)
            ->first();
        if ($check) {
            return redirect()
                ->with("error", " No KK $noKK sudah terdaftar")
                ->withInput(request()->getAll())
                ->back();
        }

        $check2 = $this->model->masyarakat
            ->where("nik", "=", $nik)
            ->first();
        if ($check2) {
            return redirect()
                ->with("error", "Nik  $nik sudah terdaftar")
                ->withInput(request()->getAll())
                ->back();
        }

        $dataKK = [
            "no_kk" => $noKK,
            "alamat" => $alamat,
            "rt" => $rt,
            "rw" => $rw,
            "kode_pos" => $kode_pos,
            "kelurahan" => $kelurahan,
            "kecamatan" => $kecamatan,
            "kabupaten" => $kabupaten,
            "provinsi" => $provinsi,
            "kk_tgl" => $tanggalKK
        ];
        if ($foto_kartu_keluarga["name"] !== "") {
            $file_extension = pathinfo($foto_kartu_keluarga['name'], PATHINFO_EXTENSION);
            $randomName = uniqid() . '.' . $file_extension;
            $fileUpload = new FileUploader();
            $fileUpload->setFile($foto_kartu_keluarga);
            $fileUpload->setTarget(storagePath("private", "/kartu_keluarga/" . $randomName));
            $fileUpload->upload();
            $dataKK["kk_file"] = $randomName;
        }
        $this->model->kartuKeluarga->create($dataKK);
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
            "no_kk" => $noKK
        ]);


        return redirect()->with("success", "Kartu keluarga berhasil ditambahkan")->to("/admin/kartu-keluarga");
    }

    public  function edit($id)
    {

        $kartuKeluarga = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi,kk_file")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("kartu_keluarga.no_kk", "=", $id)
            ->first();

        if (!$kartuKeluarga) return show404();
        $data = (object)[
            "no_kk" => $kartuKeluarga->no_kk ?? null,
            "tanggal_kk" => $kartuKeluarga->kk_tgl ?? null,
            "nik" => $kartuKeluarga->nik ?? null,
            "nama" => $kartuKeluarga->nama_lengkap ?? null,
            "alamat" => $kartuKeluarga->alamat ?? null,
            "rt" => $kartuKeluarga->rt ?? null,
            "rw" => $kartuKeluarga->rw ?? null,
            "foto_kartu_keluarga" => url("/admin/assets-kartu-keluarga/" . $kartuKeluarga->kk_file) ?? null,
            "kode_pos" => $kartuKeluarga->kode_pos ?? null,
            "kelurahan" => $kartuKeluarga->kelurahan ?? null,
            "kecamatan" => $kartuKeluarga->kecamatan ?? null,
            "kabupaten" => $kartuKeluarga->kabupaten ?? null,
            "provinsi" => $kartuKeluarga->provinsi ?? null,
        ];

        $params["data"] = (object)[
            "title" => "Ubah Kartu Keluarga",
            "description" => "Kelola Kartu Keluarga dengan mudah",
            "action_form" => url("/admin/kartu-keluarga/$id"),
            "data" => $data
        ];


        return $this->view("admin/kartu_keluarga/form", $params);
    }


    public  function update($id)
    {
        // request()->validate([
        //     "kecamatan" => "required|max:100"
        // ]);
        $validate =  request()->validate([
            "no_kk" => "required",
            "tanggal_kk" => "required",
            "nama" => "required|min:3|max:50",
            "nik" => "required|numeric|min:16",
            "alamat" => "required|max:255",
            "rt" => "required|numeric",
            "rw" => "required|numeric",
            "kelurahan" => "required|max:100",
            "kode_pos" => "required|numeric",
            "kabupaten" => "required|max:100",
            "provinsi" => "required|max:100",
            "kecamatan" => "required|max:100"
        ]);
        $noKK = request("no_kk");
        $tanggalKK = request("tanggal_kk");
        $nama = request("nama");
        $nik = request("nik");
        $alamat = request("alamat");
        $rt = request("rt");
        $rw = request("rw");
        $foto_kartu_keluarga = request("foto_kartu_keluarga");


        $check = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nik")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("kartu_keluarga.no_kk", "=", $noKK)
            ->where("kartu_keluarga.no_kk", "<>", $id)
            ->first();
        if ($check) {
            return redirect()
                ->with("error", " No KK $noKK sudah terdaftar")
                ->withInput(request()->getAll())
                ->back();
        }

        $check2 = $this->model->masyarakat
            ->where("nik", "=", $nik)
            ->where("no_kk", "<>", $id)
            ->first();
        if ($check2) {
            return redirect()
                ->with("error", "Nik  $nik sudah terdaftar")
                ->withInput(request()->getAll())
                ->back();
        }
        $idMasyarakat = $this->model->masyarakat->where("no_kk", "=", $id)->first()->nik;


        $dataKK = [
            "no_kk" => $noKK,
            "alamat" => $alamat,
            "kk_tgl" => $tanggalKK,
            "rt" => $rt,
            "rw" => $rw
        ];

        $kk  =  $this->model->kartuKeluarga->where("no_kk", "=", $id)->first();
        if ($foto_kartu_keluarga["name"] !== "") {
            $file_extension = pathinfo($foto_kartu_keluarga['name'], PATHINFO_EXTENSION);
            $randomName = uniqid() . '.' . $file_extension;
            $fileUpload = new FileUploader();
            $fileUpload->setFile($foto_kartu_keluarga);
            $fileUpload->setTarget(storagePath("private", "/kartu_keluarga/" . $randomName));
            $fileUpload->upload();
            $fileUpload->delete(storagePath("private", "/kartu_keluarga/" . $kk->kk_file));
            $dataKK["kk_file"] = $randomName;
        }
        $this->model->kartuKeluarga->where("no_kk", "=", $id)->update($dataKK);

        $this->model->masyarakat->where("nik", "=", $idMasyarakat)->update([
            "nik" => $nik,
            "nama_lengkap" => $nama,
            "no_kk" => $noKK
        ]);


        return redirect()->with("success", "Kartu keluarga berhasil diubah")->to("/admin/kartu-keluarga");
    }


    public function delete($id)
    {

        try {
            $kk = $this->model->kartuKeluarga->find($id);
            if (!$kk) {
                return response("Kartu keluarga tidak ditemukan", 404);
            }

            $masyarakat = $this->model->masyarakat->where("no_kk", "=", $kk->no_kk)->get();
            foreach ($masyarakat as $msy) {
                $this->model->user->where("nik", "=", $msy->nik)->delete();
                $this->model->masyarakat->where("nik", "=", $msy->nik)->delete();
            }
            $fileUpload = new FileUploader();
            $fileUpload->delete(storagePath("private", "/kartu_keluarga/" . $kk->kk_file));

            $this->model->kartuKeluarga->where("no_kk", "=", $id)->delete();
            return response("Kartu keluarga berhasil dihapus", 200);
        } catch (\Throwable $th) {
            return response("Kartu keluarga gagal dihapus", 500);

            // return redirect()->with("error", "Kartu keluarga gagal dihapus")->to("/admin/kartu-keluarga");
        }
    }


    public function import()
    {
        $file = request("file");
        try {
            $mainModel = new Model();
            // $mainModel->beginTransaction();
            $kkImport = new KartuKeluargaImport();
            $data =  $kkImport->import($file);
            // $mainModel->commit();
            return redirect()->with("success", "Kartu keluarga berhasil diimport")->back();
        } catch (\Throwable $th) {
            return redirect()->with("error", $th->getMessage())->back();
        }
    }
}
