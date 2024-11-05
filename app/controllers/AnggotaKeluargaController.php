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
        $kartuKeluarga = $this->model->kartuKeluarga
            ->select("kartu_keluarga.no_kk,nama_lengkap,kk_tgl,nik,alamat,rt,rw,kode_pos,kelurahan,kecamatan,kabupaten,provinsi")
            ->join("masyarakat", "kartu_keluarga.no_kk", "masyarakat.no_kk")
            ->where("kartu_keluarga.no_kk", "=", $nokk)
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
            "kode_pos" => $kartuKeluarga->kode_pos ?? null,
            "kelurahan" => $kartuKeluarga->kelurahan ?? null,
            "kecamatan" => $kartuKeluarga->kecamatan ?? null,
            "kabupaten" => $kartuKeluarga->kabupaten ?? null,
            "provinsi" => $kartuKeluarga->provinsi ?? null,
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
