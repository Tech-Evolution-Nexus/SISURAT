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
        $this->model->jsurat  = new JenisSuratModel();
        $this->model->lampiransurat  = new LampiranSuratModel();
        $this->model->lampiranpengajuanModel = new LampiranPengajuanModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->psurat = new PengajuanSuratModel();
        $this->model->users = new UserModel();
    }
    public function sendsurmas()
    {
        $nik = request("nik");
        $idsurat = request("idsurat");
        $img = request("images");
        $keterangan = request("keterangan");
        $datalampiran = $this->model->lampiransuratModel->where("id_surat", "=", $idsurat)->get();

        $data = $this->model->pengajuansurModel->create([
            "nik" => $nik,
            "id_surat" => $idsurat,
            "keterangan" => $keterangan,
            "status" => "pendding",
            "kode_kelurahan" => "123312"
        ]);

        foreach ($img['name'] as $key => $tmp_name) {
            $this->model->lampiranpengajuanModel->create([
                'id_pengajuan' => $data,
                'id_lampiran' => $datalampiran[$key]->id_lampiran,
                'url' => $img['name'][$key]
            ]);
            $fileName = $img['name'][$key];
            $fileTmpName = $img['tmp_name'][$key];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $nameFile  = uniqid() . "." . $fileExt;
            $uploader = new FileUploader();
            $uploader->setFile($fileTmpName);
            $uploader->setTarget(storagePath("private", "/masyarakat/" . $nameFile));
            $uploader->setAllowedFileTypes($allowedFileTypes);
            $uploadStatus = $uploader->upload();
            if ($uploadStatus !== true) {
                return response(["data" => $uploadStatus, "msg" => "gaga Menambahkan"], 200);
            }
        }
        return response(["data" => $idsurat, $keterangan, "msg" => "Berhasil Menambahkan"], 200);
    }


    public function getPengajuan($nik, $status)
    {
        // Buat filter status
        $statusFilter = [];
        if ($status) {
            $statusFilter = is_array($status) ? $status : explode('|', $status);
        }

        // Query data
        $data = $this->model->psurat->select(
            "pengajuan_surat.id",
            "nomor_surat",
            "no_pengantar",
            "status",
            "keterangan",
            "keterangan_ditolak",
            "file_pdf",
            "pengantar_rt",
            "pengantar_rw",
            "nik",
            "kode_kelurahan",
            "nomor_surat_tambahan",
            "pengajuan_surat.created_at",
            "pengajuan_surat.updated_at",
            "id_surat",
            "nama_surat",
            "image"
        )->join("surat", "surat.id", "=", "id_surat")->where("nik", "=", $nik);

        if (!empty($statusFilter)) {
            $data->whereIn('status', $statusFilter);
        }

        $result = $data->get();

        // Kembalikan respons
        return response([
            "data" => [
                "msg" => "Data retrieved successfully",
                "datariwayat" => $result
            ]
        ], 200);
    }

    public function getListPengajuan($nik, $status)
    {
        $user = $this->model->masyarakat
            ->select("rw,rt,role")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->join("users", "masyarakat.nik", "users.nik")
            ->where("masyarakat.nik", "=", $nik)
            ->whereIn("role", ["rw", "rt"])
            ->first();
        if ($user->role != "rw" && $user->role != "rt") {
            return response(["message" => "Anda tidak memiliki akses "], 404);
        }
        $statusAwal = $user->role == "rw" ? "di_terima_rt" : "pending";

        //mengambil data yang menunggu persetujuan berdasarkan status
        $data1 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("rw", "=", $user->rw)
            ->where("rt", "=", $user->rt)
            ->where("status", "=", $statusAwal)
            ->orderBy("pengajuan_surat.created_at", "desc")
            ->get();

        $data2 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap,rw,rt")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("rw", "=", $user->rw)
            ->where("rt", "=", $user->rt)
            ->orderBy("pengajuan_surat.created_at", "desc");

        if ($user->role === "rw") {
            $data2->where("status", "<>", "pending");
            $data2->where("status", "<>", "di_terima_rt");
        } else {
            $data2->where("status", "<>", "pending");
        }
        $data2 =  $data2->get();
        return response([
            "status" => "success",
            "message" => null,
            "data" => [
                "dataPengajuan" => $status === "pending" ? $data1 : $data2
            ]
        ], 200);
    }


    public function getDetailPengajuan($id_pengajuan)
    {
        $surat = $this->model->psurat
            ->select("nama_lengkap,nama_surat,pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,rw,rt")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("surat.id", "=", $id_pengajuan)
            ->first();
        $lampiran = $this->model->lampiranpengajuan
            ->select("nama_lampiran,url")
            ->join("lampiran", "lampiran_pengajuan.id_lampiran", "lampiran.id")
            ->where("id_pengajuan", "=", $id_pengajuan)
            ->get();
        if (!$surat) {
            return response(["message" => "Surat tidak ditemukan "], 404);
        }

        $surat->lampiran = $lampiran;

        return response([
            "status" => "success",
            "message" => null,
            "data" => [
                "dataPengajuan" => $surat
            ]
        ], 200);
    }


    public function approvalPengajuan($nik, $id_pengajuan)
    {
        request()->validate([
            "status" => "required",
        ]);
        $pengajuan = $this->model->psurat->where("id", "=", $id_pengajuan)
            ->first();
        if (!$pengajuan) {
            return response(["message" => "Pengajuan tidak ditemukan"], 404);
        }
        $user = $this->model->users->where("nik", "=", $nik)->first();
        $role = $user->role;
        $status = request("status");
        $pengantar = request("pengantar");
        $no_surat = request("no_surat");
        $no_kelurahan = request("no_kelurahan");
        $no_surat_tambahan = request("no_surat_tambahan");
        $no_surat_tambahan = request("no_surat_tambahan");
        $keteranganDitolak = request("keterangan_ditolak");
        $keterangan = request("keterangan");

        $data = [];
        if ($role == "rw") {
            if ($status == "ditolak") {
                $data["status"] = "di_tolak_rw";
            } else {
                $data["status"] = "di_terima_rw";
            }
        } else if ($role == "rt") {
            if ($status == "ditolak") {
                $data["status"] = "di_tolak_rt";
            } else {
                $data["status"] = "di_terima_rt";
            }

            $data["keterangan_ditolak"] = $keteranganDitolak;
            $data["keterangan"] = $keterangan;
        }

        return response(["message" => $data], 200);
        $this->model->psurat->where("id", "=", $id_pengajuan)
            ->update($data);
        return response(["message" => "Success"], 200);
    }
}
