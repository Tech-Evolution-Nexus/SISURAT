<?php

namespace app\controllers\api;

use app\abstract\Model;
use app\models\BeritaModel;
use app\models\FieldsModel;
use app\models\FieldValuesModel;
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
    private $mainmodel;

    public function __construct()
    {
        $this->model = (object) [];
        $this->model->pengajuansurModel = new PengajuanSuratModel();
        $this->model->lampiranpengajuanModel = new LampiranPengajuanModel();
        $this->model->lampiransuratModel = new LampiranSuratModel();
        $this->model->jsurat = new JenisSuratModel();
        $this->model->lampiransurat = new LampiranSuratModel();
        $this->model->lampiranpengajuanModel = new LampiranPengajuanModel();
        $this->model->kartuKeluarga = new KartuKeluargaModel();
        $this->model->masyarakat = new MasyarakatModel();
        $this->model->psurat = new PengajuanSuratModel();
        $this->model->users = new UserModel();
        $this->model->fields = new FieldsModel();
        $this->model->fieldsvalue = new FieldValuesModel();
        $this->mainmodel = new Model();
    }
    public function sendsurmas()
    {
        try {
            header("Access-Control-Allow-Origin: *");

            $nik = request("nik");
            $idsurat = request("idsurat");
            $img = request("images");
            $keterangan = request("keterangan");
            $fields = request("fields");
            $datalampiran = $this->model->lampiransuratModel->where("id_surat", "=", $idsurat)->get();

            if (!$datalampiran) {
                return response(["status" => false, "message" => "Surat Tidak Ditemukan", "data" => []], 200);
            }

            $data = $this->model->masyarakat->select("nik,kartu_keluarga.rt")->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")->where("masyarakat.nik", "=", $nik)->first();

            if (!$data) {
                return response(["status" => false, "message" => "Masyarakat Tidak Ditemukan", "data" => []], 200);
            }

            $data2 = $this->model->users->select("rt,role,fcm_token")->join("masyarakat", "masyarakat.nik", "users.nik")->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->where("kartu_keluarga.rt", "=", $data->rt)
                ->where("users.role", "=", "rt")
                ->first();

            if (!$data2) {
                return response(["status" => false, "message" => "Ketua Rt Tidak ditemukan", "data" => []], 200);
            }

            $this->mainmodel->beginTransaction();
            $data = $this->model->pengajuansurModel->create([
                "nik" => $nik,
                "id_surat" => $idsurat,
                "keterangan" => $keterangan,
                "status" => "pending",
            ]);
            $datafields = $this->model->fields->where("id_surat", "=", $idsurat)->get();
            if ($fields["name"][0] != "") {
                foreach ($fields["name"] as $key => $tmp_name) {
                    $this->model->fieldsvalue->create([
                        'id_pengajuan' => $data,
                        'id_field' => $datafields[$key]->id,
                        'value' => $fields['name'][$key]
                    ]);
                }
            }
            foreach ($img['name'] as $key => $tmp_name) {
                $fileName = $img['name'][$key];
                $fileTmpName = $img['tmp_name'][$key];
                $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
                $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
                $nameFile = uniqid() . "." . $fileExt;
                $this->model->lampiranpengajuanModel->create([
                    'id_pengajuan' => $data,
                    'id_lampiran' => $datalampiran[$key]->id_lampiran,
                    'url' => $nameFile
                ]);
                $uploader = new FileUploader();
                $uploader->setFile($fileTmpName);
                $uploader->setTarget(storagePath("private", "/masyarakat/" . $nameFile));
                $uploader->setAllowedFileTypes($allowedFileTypes);
                $uploadStatus = $uploader->upload();
                if ($uploadStatus !== true) {
                    return response(["status" => false, "message" => "Gagal Menambahkan Data", "data" => $uploadStatus], 200);
                }
            }

            if ($data2->fcm_token != null) {
                pushnotifikasito($data2->fcm_token, "Ada Surat Baru Masuk", "Silahkan Klik Untuk Melakukan Persetujuan");
            }
            $this->mainmodel->commit();
            return response(["status" => true, "message" => "Berhasil Menambahkan Data", "data" => []], 200);
        } catch (Exception $e) {
            $this->mainmodel->rollBack();
        }
    }

    // public function sendsurmas()
    // {
    //     try {
    //         header("Access-Control-Allow-Origin: *");

    //         $nik = request("nik");
    //         $idsurat = request("idsurat");
    //         $img = request("images");
    //         $keterangan = request("keterangan");
    //         $fields = request("fields");

    //         $datalampiran = $this->model->lampiransuratModel->where("id_surat", $idsurat)->get();
    //         if (!$datalampiran) {
    //             return response(["status" => false, "message" => "Data lampiran tidak ditemukan"], 400);
    //         }

    //         $this->mainmodel->beginTransaction();

    //         // Buat pengajuan surat
    //         $pengajuan = $this->model->pengajuansurModel->create([
    //             "nik" => $nik,
    //             "id_surat" => $idsurat,
    //             "keterangan" => $keterangan,
    //             "status" => "pending",
    //         ]);

    //         if (!$pengajuan) {
    //             return response(["status" => false, "message" => "Gagal membuat pengajuan"], 400);
    //         }

    //         // Simpan fields jika ada
    //         if (!empty($fields['name'][0])) {
    //             $datafields = $this->model->fields->where("id_surat", $idsurat)->get();
    //             foreach ($fields['name'] as $key => $value) {
    //                 $this->model->fieldsvalue->create([
    //                     'id_pengajuan' => $pengajuan,
    //                     'id_field' => $datafields[$key]->id ?? null,
    //                     'value' => $value,
    //                 ]);
    //             }
    //         }

    //         // Simpan lampiran
    //         $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
    //         foreach ($img['name'] as $key => $fileName) {
    //             $fileTmpName = $img['tmp_name'][$key];
    //             $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    //             $uniqueFileName = uniqid() . "." . $fileExt;

    //             $this->model->lampiranpengajuanModel->create([
    //                 'id_pengajuan' => $pengajuan,
    //                 'id_lampiran' => $datalampiran[$key]->id_lampiran ?? null,
    //                 'url' => $uniqueFileName,
    //             ]);

    //             $uploader = new FileUploader();
    //             $uploader->setFile($fileTmpName);
    //             $uploader->setTarget(storagePath("private", "/masyarakat/" . $uniqueFileName));
    //             $uploader->setAllowedFileTypes($allowedFileTypes);

    //             if (!$uploader->upload()) {
    //                 $this->mainmodel->rollBack();
    //                 return response(["status" => false, "message" => "Gagal mengunggah lampiran"], 400);
    //             }
    //         }

    //         // Kirim notifikasi ke ketua RT
    //         $dataMasyarakat = $this->model->masyarakat
    //             ->select("nik,kartu_keluarga.rt")
    //             ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
    //             ->where("masyarakat.nik", $nik)
    //             ->first();

    //         if ($dataMasyarakat) {
    //             $dataRT = $this->model->users
    //                 ->select("rt,role,fcm_token")
    //                 ->join("masyarakat", "masyarakat.nik", "users.nik")
    //                 ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
    //                 ->where("kartu_keluarga.rt", $dataMasyarakat->rt)
    //                 ->where("users.role", "rt")
    //                 ->first();

    //             if ($dataRT && $dataRT->fcm_token) {
    //                 pushnotifikasito($dataRT->fcm_token, "Ada Surat Baru Masuk", "Silahkan Klik Untuk Melakukan Persetujuan");
    //                 $this->mainmodel->commit();
    //                 return response(["status" => true, "message" => "Berhasil menambahkan data"], 200);
    //             }

    //             return response(["status" => false, "message" => "Ketua RT tidak ditemukan"], 400);
    //         }

    //         return response(["status" => false, "message" => "Data masyarakat tidak ditemukan"], 400);
    //     } catch (Exception $e) {
    //         $this->mainmodel->rollBack();
    //         return response(["status" => false, "message" => "Terjadi kesalahan: " . $e->getMessage()], 500);
    //     }
    // }

    public function getPengajuan($nik, $status)
    {
        // Buat filter status
        $statusFilter = [];
        if ($status) {
            $statusFilter = is_array($status) ? $status : explode(',', $status);
        }

        // Query data
        $data = $this->model->psurat->select(
            "pengajuan_surat.id",
            "nomor_surat",
            "no_pengantar_rt",
            "no_pengantar_rw",
            "status",
            "keterangan",
            "keterangan_ditolak",
            "nik",
            "kode_kelurahan",
            "pengajuan_surat.created_at",
            "pengajuan_surat.updated_at",
            "id_surat",
            "nama_surat",
            "image"
        )->join("surat", "surat.id", "id_surat")->where("nik", "=", $nik)->whereIn('status', $statusFilter)->orderBy("pengajuan_surat.created_at", "desc")->get();

        if ($data) {
            return response(["status" => true, "message" => "Data Berhasil Diambil", "data" => $data], 200);
        } else {
            return response(["status" => false, "message" => "Data Gagal Diambil / Data Masih Kosong", "data" => []], 200);
        }
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
        $data1 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap,surat.image")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->where("status", "=", $statusAwal)
            ->orderBy("pengajuan_surat.updated_at", "desc");

        if ($user->role === "rw") {
            $data1->where("rw", "=", $user->rw);
        } else {
            $data1->where("rw", "=", $user->rw);
            $data1->where("rt", "=", $user->rt);
        }
        $data1 = $data1->get();
        $data2 = $this->model->psurat
            ->select("pengajuan_surat.*,pengajuan_surat.created_at as tanggal_pengajuan,nama_surat,nama_lengkap,rw,rt,surat.image")
            ->join("surat", "pengajuan_surat.id_surat", "surat.id")
            ->join("masyarakat", "pengajuan_surat.nik", "masyarakat.nik")
            ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
            ->orderBy("pengajuan_surat.updated_at", "desc");

        if ($user->role === "rw") {
            $data2->where("rw", "=", $user->rw);
            $data2->where("status", "<>", "pending");
            $data2->where("status", "<>", "di_terima_rt");
        } else {
            $data2->where("rw", "=", $user->rw);
            $data2->where("rt", "=", $user->rt);
            $data2->where("status", "<>", "pending");
        }
        $data2->where("status", "<>", "dibatalkan");
        $data2 = $data2->get();
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
            "data" => [
                "status" => "success",
                "message" => null,
                "dataPengajuan" => $surat
            ]
        ], 200);
    }


    public function approvalPengajuan($nik, $id_pengajuan)
    {
        header("Access-Control-Allow-Origin: *");
        try {
            $pengajuan = $this->model->psurat->where("id", "=", $id_pengajuan)
                ->first();
            if (!$pengajuan) {
                return response(["message" => "Pengajuan tidak ditemukan"], 200);
            }

            $user = $this->model->users->join("masyarakat", "masyarakat.nik", "users.nik")->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")->where("users.nik", "=", $nik)->first();
            $role = $user->role;
            $status = request("status");
            $keterangan = request("keterangan");
            $nopegantar = request("nopegantarrt");

            $dataMasyarakat = $this->model->users->select("rt,role,fcm_token")
                ->join("masyarakat", "masyarakat.nik", "users.nik")
                ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                ->where("users.nik", "=", $pengajuan->nik)
                ->first();

            if ($role == "rt") {
                $data2 = $this->model->users->select("rt,role,fcm_token")
                    ->join("masyarakat", "masyarakat.nik", "users.nik")
                    ->join("kartu_keluarga", "masyarakat.no_kk", "kartu_keluarga.no_kk")
                    ->where("kartu_keluarga.rw", "=", $user->rw)
                    ->where("users.role", "=", "rw")
                    ->first();

                if (!$data2) {
                    return response(["status" => false, "message" => "Ketua Rw Tidak ditemukan", "data" => []], 200);
                }
                if ($status == "ditolak") {
                    if ($data2->fcm_token != null) {
                        pushnotifikasito($dataMasyarakat->fcm_token, "Pemberitahuan", "Surat Anda Ditolak");
                    }
                } else {
                    if ($data2->fcm_token != null) {
                        pushnotifikasito($data2->fcm_token, "Ada Surat Baru Masuk", "Silahkan Klik Untuk Melakukan Persetujuan");
                    }
                    if ($dataMasyarakat->fcm_token != null) {
                        pushnotifikasito($dataMasyarakat->fcm_token, "Pemberitahuan", "Surat Anda Telah Disetujui oleh ketua $role ");
                    }
                }
            }




            if (!$dataMasyarakat) {
                return response(["status" => false, "message" => "Masyarakat Tidak ditemukan", "data" => []], 200);
            }


            if ($role == "rw") {
                $randomNumber = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
                $nopegantar = "NPRW-" . $randomNumber;
            }
            if ($keterangan == "") {
                $keterangan = null;
            }
            $data = [];
            $data["status"] = ($role == "rw")
                ? ($status == "ditolak" ? "di_tolak_rw" : "di_terima_rw")
                : ($status == "ditolak" ? "di_tolak_rt" : "di_terima_rt");

            $data["keterangan_ditolak"] = $keterangan;
            $role == "rw" ? $data["no_pengantar_rw"] = $nopegantar : $data["no_pengantar_rt"] = $nopegantar;


            $this->model->psurat->where("id", "=", $id_pengajuan)
                ->update($data);
            return response(["message" => "Success", $data, $id_pengajuan, $status, $keterangan], 200);
        } catch (\Throwable $th) {
            return response(["message" => "Error", "data" => $th->getMessage()], 500);
        }
    }
}
