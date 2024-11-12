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
        if (!auth()->check()) {
            redirect("/login");
        }
        $this->model =  (object)[];
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
    }
    public  function index($nokk)
    {
        $data = $this->model->masyarakat
            ->where("no_kk", "=", $nokk)
            ->orderBy("status_keluarga", "asc")
            ->get();
        $kepalaKeluarga = $this->model->masyarakat
            ->where("no_kk", "=", $nokk)
            ->where("status_keluarga", "=", "kk")
            ->first();

        $params["data"] = (object)[
            "title" => "Anggota Keluarga ",
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
            "data" => $data,
            "nokk" => $nokk
        ];

        return $this->view("admin/anggota_keluarga/form", $params);
    }
    public  function store($nokk)
    {
        try {
            request()->validate([
                "nik" => "required|min:16|max:16",
                "nama" => "required|max:70",
                "jenis_kelamin" => "required",
                "tempat_lahir" => "required",
                "tanggal_lahir" => "required|date",
                "agama" => "required",
                "pendidikan" => "required",
                "pekerjaan" => "required",
                "gol_darah" => "required",
                "status_perkawinan" => "required",
                "status_keluarga" => "required",
                "kewarganegaraan" => "required",
                "no_paspor" => "required",
                "no_kitap" => "required",
                "nama_ayah" => "required",
                "nama_ibu" => "required",
            ], [
                "nik.required" => "NIK wajib diisi.",
                "nik.min" => "NIK harus terdiri dari 16 karakter.",
                "nik.max" => "NIK harus terdiri dari 16 karakter.",
                "nama.required" => "Nama wajib diisi.",
                "nama.max" => "Nama tidak boleh lebih dari 70 karakter.",
                "jenis_kelamin.required" => "Jenis kelamin wajib diisi.",
                "tempat_lahir.required" => "Tempat lahir wajib diisi.",
                "tanggal_lahir.required" => "Tanggal lahir wajib diisi.",
                "tanggal_lahir.date" => "Format tanggal lahir tidak valid.",
                "agama.required" => "Agama wajib diisi.",
                "pendidikan.required" => "Pendidikan wajib diisi.",
                "pekerjaan.required" => "Pekerjaan wajib diisi.",
                "gol_darah.required" => "Golongan darah wajib diisi.",
                "status_perkawinan.required" => "Status perkawinan wajib diisi.",
                "status_keluarga.required" => "Status keluarga wajib diisi.",
                "kewarganegaraan.required" => "Kewarganegaraan wajib diisi.",
                "no_paspor.required" => "Nomor paspor wajib diisi.",
                "no_kitap.required" => "Nomor KITAP wajib diisi.",
                "nama_ayah.required" => "Nama ayah wajib diisi.",
                "nama_ibu.required" => "Nama ibu wajib diisi."
            ]);

            $nama = request("nama");
            $nik = request("nik");
            $jk = request("jenis_kelamin");
            $tempat_lahir = request("tempat_lahir");
            $tanggal_lahir = request("tanggal_lahir");
            $agama = request("agama");
            $pendidikan = request("pendidikan");
            $pekerjaan = request("pekerjaan");
            $gol_darah = request("gol_darah");
            $status_perkawinan = request("status_perkawinan");
            $tgl_perkawinan = request("tgl_perkawinan");
            $status_keluarga = request("status_keluarga");
            $kewarganegaraan = request("kewarganegaraan");
            $no_paspor = request("no_paspor");
            $no_kitap = request("no_kitap");
            $nama_ayah = request("nama_ayah");
            $nama_ibu = request("nama_ibu");



            $check2 = $this->model->masyarakat
                ->where("nik", "=", $nik)
                ->first();
            if ($check2) {
                return redirect()
                    ->with("error", "Nik $nik sudah terdaftar")
                    ->withInput(request()->getAll())
                    ->back();
            }


            $data = [
                "nik" => $nik,
                "nama_lengkap" => $nama,
                "jenis_kelamin" => $jk,
                "tempat_lahir" => $tempat_lahir,
                "tgl_lahir" => $tanggal_lahir,
                "agama" => $agama,
                "pendidikan" => $pendidikan,
                "pekerjaan" => $pekerjaan,
                "golongan_darah" => $gol_darah,
                "status_perkawinan" => $status_perkawinan,
                "tgl_perkawinan" => $tgl_perkawinan,
                "status_keluarga" => $status_keluarga,
                "kewarganegaraan" => $kewarganegaraan,
                "no_paspor" => $no_paspor,
                "no_kitap" => $no_kitap,
                "nama_ayah" => $nama_ayah,
                "nama_ibu" => $nama_ibu,
                "no_kk" => $nokk
            ];
            $this->model->masyarakat->create($data);


            return redirect()->with("success", "Anggota keluarga berhasil ditambah")->to("/admin/kartu-keluarga/$nokk/anggota-keluarga");
        } catch (\Throwable $th) {
            return redirect()->with("error", "Anggota keluarga gagal ditambah")->back();
        }
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
            "data" => $data,
            "nokk" => $nokk
        ];

        return $this->view("admin/anggota_keluarga/form", $params);
    }
    public  function show($nokk, $nik)
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
        $status = $masyarakat->status_keluarga === "kk" ? "Kepala Keluarga" : $masyarakat->status_keluarga;
        $params["data"] = (object)[
            "title" => "$masyarakat->nama_lengkap - $status",
            "description" => "",
            "data" => $data,
            "nokk" => $nokk
        ];

        return $this->view("admin/anggota_keluarga/detail", $params);
    }


    public  function update($nokk, $nikLama)
    {
        try {
            request()->validate([
                "nik" => "required|min:16|max:16",
                "nama" => "required|max:70",
                "jenis_kelamin" => "required",
                "tempat_lahir" => "required",
                "tanggal_lahir" => "required|date",
                "agama" => "required",
                "pendidikan" => "required",
                "pekerjaan" => "required",
                "gol_darah" => "required",
                "status_perkawinan" => "required",
                "status_keluarga" => "required",
                "kewarganegaraan" => "required",
                "no_paspor" => "required",
                "no_kitap" => "required",
                "nama_ayah" => "required",
                "nama_ibu" => "required",
            ], [
                "nik.required" => "NIK wajib diisi.",
                "nik.min" => "NIK harus terdiri dari 16 karakter.",
                "nik.max" => "NIK harus terdiri dari 16 karakter.",
                "nama.required" => "Nama wajib diisi.",
                "nama.max" => "Nama tidak boleh lebih dari 70 karakter.",
                "jenis_kelamin.required" => "Jenis kelamin wajib diisi.",
                "tempat_lahir.required" => "Tempat lahir wajib diisi.",
                "tanggal_lahir.required" => "Tanggal lahir wajib diisi.",
                "tanggal_lahir.date" => "Format tanggal lahir tidak valid.",
                "agama.required" => "Agama wajib diisi.",
                "pendidikan.required" => "Pendidikan wajib diisi.",
                "pekerjaan.required" => "Pekerjaan wajib diisi.",
                "gol_darah.required" => "Golongan darah wajib diisi.",
                "status_perkawinan.required" => "Status perkawinan wajib diisi.",
                "status_keluarga.required" => "Status keluarga wajib diisi.",
                "kewarganegaraan.required" => "Kewarganegaraan wajib diisi.",
                "no_paspor.required" => "Nomor paspor wajib diisi.",
                "no_kitap.required" => "Nomor KITAP wajib diisi.",
                "nama_ayah.required" => "Nama ayah wajib diisi.",
                "nama_ibu.required" => "Nama ibu wajib diisi."
            ]);

            $nama = request("nama");
            $nik = request("nik");
            $jk = request("jenis_kelamin");
            $tempat_lahir = request("tempat_lahir");
            $tanggal_lahir = request("tanggal_lahir");
            $agama = request("agama");
            $pendidikan = request("pendidikan");
            $pekerjaan = request("pekerjaan");
            $gol_darah = request("gol_darah");
            $status_perkawinan = request("status_perkawinan");
            $tgl_perkawinan = request("tgl_perkawinan");
            $status_keluarga = request("status_keluarga");
            $kewarganegaraan = request("kewarganegaraan");
            $no_paspor = request("no_paspor");
            $no_kitap = request("no_kitap");
            $nama_ayah = request("nama_ayah");
            $nama_ibu = request("nama_ibu");



            $check2 = $this->model->masyarakat
                ->where("nik", "<>", $nikLama)
                ->where("nik", "=", $nik)
                ->first();
            if ($check2) {
                return redirect()
                    ->with("error", "Nik $nik sudah terdaftar")
                    ->withInput(request()->getAll())
                    ->back();
            }


            $data = [
                "nik" => $nik,
                "nama_lengkap" => $nama,
                "jenis_kelamin" => $jk,
                "tempat_lahir" => $tempat_lahir,
                "tgl_lahir" => $tanggal_lahir,
                "agama" => $agama,
                "pendidikan" => $pendidikan,
                "pekerjaan" => $pekerjaan,
                "golongan_darah" => $gol_darah,
                "status_perkawinan" => $status_perkawinan,
                "tgl_perkawinan" => $tgl_perkawinan,
                "status_keluarga" => $status_keluarga,
                "kewarganegaraan" => $kewarganegaraan,
                "no_paspor" => $no_paspor,
                "no_kitap" => $no_kitap,
                "nama_ayah" => $nama_ayah,
                "nama_ibu" => $nama_ibu,
            ];
            $this->model->masyarakat->where("nik", "=", $nikLama)->update($data);


            return redirect()->with("success", "Anggota keluarga berhasil diubah")->to("/admin/kartu-keluarga/$nokk/anggota-keluarga");
        } catch (\Throwable $th) {
            return redirect()->with("error", "Anggota keluarga gagal diubah")->back();
        }
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
