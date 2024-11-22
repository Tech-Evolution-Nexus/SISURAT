<?php

namespace app\controllers\api;

use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\UserModel;
use Exception;

class AuthApiController
{

    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->UserModel = new UserModel();
        $this->model->masyarakatModel = new MasyarakatModel();
        $this->model->KartuKeluargaModel = new KartuKeluargaModel();
    }

    public function Login()
    {
        try {
            $jsonData = json_decode(file_get_contents("php://input"), true);
            if (!$jsonData) {
                return response([
                    "message" => "Data tidak valid",
                    "status" => false,
                    "data" => []
                ], 400);
            }
            $nik = $jsonData["nik"];
            $password = $jsonData["password"];
            $fcm = $jsonData["fcm_token"];
            $users = $this->model->UserModel->select("masyarakat.nik,password,role,masyarakat.no_kk")->join("masyarakat", "masyarakat.nik", "users.nik")->where("users.nik", "=", $nik)->first();
            if ($users) {
                if (password_verify($password, $users->password)) {
                    if ($fcm != null || !empty($fcm)) {
                        $updateData = ["fcm_token" => $fcm];
                        $this->model->UserModel->where("nik", "=", $nik)->update($updateData);
                    }
                    return response([
                        "message" => "Berhasil Login",
                        "status" => true,
                        "data" => $users
                    ], 200);
                } else {
                    return response([
                        "message" => "Password Salah",
                        "status" => false,
                        "data" => []
                    ], 400);
                }
            } else {
                return response([
                    "message" => "NIK belum terdaftar. Silakan lakukan registrasi terlebih dahulu",
                    "status" => false,
                    "data" => []
                ], 400);
            }
        } catch (Exception $th) {
            return response([
                "message" => "$th",
                "status" => false,
                "data" => []
            ], 500);
        }
    }

    public function Veriv()
    {
        // Membaca data JSON dari request body
        $jsonData = json_decode(file_get_contents("php://input"), true);

        // Memeriksa apakah data JSON valid
        if (!$jsonData) {
            return response([
                "message" => "Data tidak valid",
                "status" => false,
                "data" => []
            ], 400);
        }
        $nik = $jsonData["nik"];
        $masyarakat = $this->model->masyarakatModel->where("nik", "=", $nik)->first();

        if (!$masyarakat) {
            // Jika NIK belum terdaftar di masyarakat
            return response([
                "message" => "NIK belum terdaftar di masyarakat. Silakan registrasi.",
                "status" => false,
                "data" => []
            ], 200);
        }
        
        // Jika NIK ditemukan di masyarakat
        $user = $this->model->UserModel->where("nik", "=", $nik)->first();
        
        if (!$user) {
            // Jika NIK ditemukan di masyarakat tetapi belum terdaftar di user
            return response([
                "message" => "NIK ditemukan di masyarakat. Lanjutkan ke verifikasi.",
                "status" => true,
                "data" => []
            ], 200);
        }
        
        // Jika NIK ditemukan di kedua tabel (masyarakat dan user)
        return response([
            "message" => "NIK sudah terdaftar di masyarakat dan user.",
            "status" => null,
            "data" => []
        ], 200);
    }


    public function Aktivasi()
    {
        // Membaca data JSON dari request body
        $jsonData = json_decode(file_get_contents("php://input"), true);

        // Memeriksa apakah data JSON valid
        if (!$jsonData) {
            return response([
                "message" => "Data tidak valid",
                "status" => false,
                "data" => []
            ], 400);
        }

        // Mengambil data dari JSON
        $nik = $jsonData["nik"] ?? null;
        $no_hp = $jsonData["no_hp"] ?? null;
        $password = $jsonData["password"] ?? null;

        // Validasi input
        if (empty($nik) || empty($no_hp) || empty($password)) {
            return response([
                "message" => "semua field harus di isi.",
                "status" => false,
                "data" => []
            ], 200);
        }

        // Periksa apakah NIK ada di tabel masyarakat
        $users = $this->model->masyarakatModel->where("nik", "=", $nik)->first();
        if ($users) {
            // Periksa apakah NIK sudah diaktivasi
            $userExists = $this->model->UserModel->where("nik", "=", $nik)->first();
            if ($userExists) {
                return response([
                    "message" => "NIK sudah diaktivasi sebelumnya. Silakan login.",
                    "status" => true,
                    "data" => []
                ], 200);
            
            } else {
                // Hash password sebelum menyimpan
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // Simpan data ke tabel users
                $this->model->UserModel->create([
                    "nik" => $nik,
                    "no_hp" => $no_hp,
                    "password" => $hashedPassword
                ]);

                return response([
                    "message" => "Aktivasi berhasil. Silakan login.",
                    "status" => true,
                    "data" => []
                ], 200);
            }
        } else {
            // Jika NIK tidak ditemukan di data masyarakat
            return response([
                "message" => "NIK tidak ditemukan di data masyarakat.",
                "status" => false,
                "data" => []
            ], 200);
        }

        exit;
    }



    public function register()
    {
        // Ambil data dari JSON
        $jsonData = json_decode(file_get_contents('php://input'), true);


        $nik = $jsonData["nik"] ?? null;
        $password = $jsonData["password"] ?? null;
        $no_hp = $jsonData["no_hp"] ?? null;
        $nama_lengkap = $jsonData["nama_lengkap"] ?? null;
        $jenis_kelamin = $jsonData["jenis_kelamin"] ?? null;
        $tempat_lahir = $jsonData["tempat_lahir"] ?? null;
        $tgl_lahir = $jsonData["tgl_lahir"] ?? null;
        $agama = $jsonData["agama"] ?? null;
        $pendidikan = $jsonData["pendidikan"] ?? null;
        $pekerjaan = $jsonData["pekerjaan"] ?? null;
        $status_perkawinan = $jsonData["status_perkawinan"] ?? null;
        $status_keluarga = $jsonData["status_keluarga"] ?? null;
        $kewarganegaraan = $jsonData["kewarganegaraan"] ?? null;
        $nama_ayah = $jsonData["nama_ayah"] ?? null;
        $nama_ibu = $jsonData["nama_ibu"] ?? null;
        $no_kk = $jsonData["no_kk"] ?? null;
        $alamat = $jsonData["alamat"] ?? null;
        $rt = $jsonData["rt"] ?? null;
        $rw = $jsonData["rw"] ?? null;
        $kode_pos = $jsonData["kode_pos"] ?? null;
        $kelurahan = $jsonData["kelurahan"] ?? null;
        $kecamatan = $jsonData["kecamatan"] ?? null;
        $kabupaten = $jsonData["kabupaten"] ?? null;
        $provinsi = $jsonData["provinsi"] ?? null;
        $kk_tgl = $jsonData["kk_tgl"] ?? null;

        if (empty($nik) || empty($nama_lengkap) || empty($password) || empty($no_hp) || empty($no_kk)) {
            header('Content-Type: application/json');
            echo json_encode([
                "data" => [
                    "msg" => "Field NIK, nama lengkap, password, nomor HP, dan No KK wajib diisi.",
                    "status" => false
                ]
            ]);
            exit;
        }

        // Simpan data ke tabel kartu keluarga
        $this->model->KartuKeluargaModel->create([
            "no_kk" => $no_kk,
            "alamat" => $alamat,
            "rt" => $rt,
            "rw" => $rw,
            "kode_pos" => $kode_pos,
            "kelurahan" => $kelurahan,
            "kecamatan" => $kecamatan,
            "kabupaten" => $kabupaten,
            "provinsi" => $provinsi,
            "kk_tgl" => $kk_tgl
        ]);

        // Simpan data ke tabel masyarakat
        $this->model->masyarakatModel->create([
            "nik" => $nik,
            "nama_lengkap" => $nama_lengkap,
            "jenis_kelamin" => $jenis_kelamin,
            "tempat_lahir" => $tempat_lahir,
            "tgl_lahir" => $tgl_lahir,
            "agama" => $agama,
            "pendidikan" => $pendidikan,
            "pekerjaan" => $pekerjaan,
            "status_perkawinan" => $status_perkawinan,
            "status_keluarga" => $status_keluarga,
            "kewarganegaraan" => $kewarganegaraan,
            "nama_ayah" => $nama_ayah,
            "nama_ibu" => $nama_ibu,
            "no_kk" => $no_kk
        ]);

        // Simpan data ke tabel user
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->model->UserModel->create([
            "nik" => $nik,
            "password" => $hashedPassword,
            "no_hp" => $no_hp,
            "role" => "masyarakat"
        ]);

        // Kirim respons sukses
        header('Content-Type: application/json');
        echo json_encode([
            "data" => [
                "msg" => "Registrasi berhasil.",
                "status" => true
            ]
        ]);
        exit;
    }
}
