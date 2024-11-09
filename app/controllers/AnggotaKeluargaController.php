<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;

class AnggotaKeluargaController extends Controller
{
    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
    }
    public  function index($nokk)
    {
        $data = $this->model->masyarakat
            ->where("no_kk", "=", $nokk)
            ->orderBy("masyarakat.created_at", "desc")
            ->get();

        $params["data"] = (object)[
            "title" => "Anggota Keluarga",
            "description" => "Kelola Anggota Keluarga dengan mudah",
            "data" => $data,
            "no_kk" => $nokk
        ];

        return $this->view("admin/anggota_keluarga/anggota_keluarga", $params);
    }
    public  function create($nokk)
    {
        // default value
        $data = (object)[
            "nik" => "",
            "nama" => "",
            "jenis_kelamin" => "",
            "tempat_lahir" => "",
            "tanggal_lahir" => "",
            "agama" => "",
            "pendidikan" => "",
            "pekerjaan" => "",
            "gol_darah" => "",
            "status_perkawinan" => "",
            "tgl_perkawinan" => "",
            "status_keluarga" => "",
            "kewarganegaraan" => "",
            "no_paspor" => "",
            "no_kitap" => "",
            "nama_ayah" => "",
            "nama_ibu" => "",
        ];
        $params["data"] = (object)[
            "title" => "Tambah Anggota Keluarga",
            "description" => "Kelola Anggota Keluarga dengan mudah",
            "action_form" => url("/admin/kartu-keluarga/$nokk/anggota-keluarga"),
            "data" => $data
        ];

        return $this->view("admin/anggota_keluarga/form", $params);
    }
    public  function store($nokk)
    {
        request()->validate([
            "nik" => "",
            "nama" => "",
            "jenis_kelamin" => "",
            "tempat_lahir" => "",
            "tanggal_lahir" => "",
            "agama" => "",
            "pendidikan" => "",
            "pekerjaan" => "",
            "gol_darah" => "",
            "status_perkawinan" => "",
            "tgl_perkawinan" => "",
            "status_keluarga" => "",
            "kewarganegaraan" => "",
            "no_paspor" => "",
            "no_kitap" => "",
            "nama_ayah" => "",
            "nama_ibu" => "",
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


        $check = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nik")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("kartu_keluarga.no_kk", "=", $noKK)
            ->where("nik", "=", $nik)
            ->first();
        if ($check) return redirect()->with("error", "Nik Kepala Keluarga dan No KK $noKK sudah terdaftar")->withInput(request()->getAll())->back();

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
            "no_kk" => $noKK
        ]);


        return redirect()->with("success", "Kartu keluarga berhasil ditambahkan")->to("/admin/kartu-keluarga");
    }

    public  function edit($nokk, $nik)
    {
        $masyarakat = $this->model->masyarakat
            ->where("nik", "=", $nik)
            ->first();

        if (!$masyarakat) return show404();
        $data = (object)[
            "nik" => $masyarakat->nik,
            "nama" => $masyarakat->nama_lengkap,
            "jenis_kelamin" => $masyarakat->jenis_kelamin,
            "tempat_lahir" => $masyarakat->tempat_lahir,
            "tanggal_lahir" => $masyarakat->tgl_lahir,
            "agama" => $masyarakat->agama,
            "pendidikan" => $masyarakat->pendidikan,
            "pekerjaan" => $masyarakat->pekerjaan,
            "gol_darah" => $masyarakat->golongan_darah,
            "status_perkawinan" => $masyarakat->status_perkawinan,
            "tgl_perkawinan" => $masyarakat->tgl_perkawinan,
            "status_keluarga" => $masyarakat->status_keluarga,
            "kewarganegaraan" => $masyarakat->kewarganegaraan,
            "no_paspor" => $masyarakat->no_paspor,
            "no_kitap" => $masyarakat->no_kitap,
            "nama_ayah" => $masyarakat->nama_ibu,
            "nama_ibu" => $masyarakat->nama_ayah,

        ];
        $params["data"] = (object)[
            "title" => "Ubah Anggota Keluarga",
            "description" => "Kelola Anggota Keluarga dengan mudah",
            "action_form" => url("/admin/kartu-keluarga/$nokk/anggota-keluarga/$nik"),
            "data" => $data
        ];

        return $this->view("admin/anggota_keluarga/form", $params);
    }


    public  function update($nokk)
    {
        // request()->validate([
        //     "kecamatan" => "required|max:100"
        // ]);
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
            ->select("kartu_keluarga.no_kk,nik")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("kartu_keluarga.no_kk", "=", $noKK)
            ->where("nik", "=", $nik)
            ->where("kartu_keluarga.no_kk", "<>", $nokk)
            ->first();
        if ($check) {
            return redirect()
                ->with("error", "Nik Kepala Keluarga dan No KK $noKK sudah terdaftar")
                ->withInput(request()->getAll())
                ->back();
        }

        $check2 = $this->model->masyarakat
            ->where("no_kk", "=", $noKK)
            ->where("no_kk", "<>", $nokk)
            ->first();
        if ($check2) {
            return redirect()
                ->with("error", "Nik Kepala Keluarga dan No KK $noKK sudah terdaftar")
                ->withInput(request()->getAll())
                ->back();
        }
        $idMasyarakat = $this->model->masyarakat->where("no_kk", "=", $nokk)->first()->nik;
        $this->model->kartuKeluarga->update($nokk, [
            "no_kk" => $noKK,
            "alamat" => $alamat,
            "kk_tgl" => $tanggalKK
        ]);
        $this->model->masyarakat->update($idMasyarakat, [
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


        return redirect()->with("success", "Kartu keluarga berhasil diubah")->to("/admin/kartu-keluarga");
    }


    public function delete($nokk, $nik)
    {
        try {
            $check = $this->model->kartuKeluarga->find($nokk);
            if (!$check) {
                return redirect()
                    ->with("error", "Kartu keluarga tidak ditemukan")
                    ->back();
            }

            $masyarakat = $this->model->masyarakat->where("no_kk", "=", $check->no_kk)->get();
            foreach ($masyarakat as $msy) {
                $this->model->masyarakat->delete($msy->nik);
            }
            $this->model->kartuKeluarga->delete($nokk);

            return redirect()->with("success", "Kartu keluarga berhasil dihapus")->to("/admin/kartu-keluarga");
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->with("error", "Kartu keluarga gagal dihapus")->to("/admin/kartu-keluarga");
        }
    }
}
