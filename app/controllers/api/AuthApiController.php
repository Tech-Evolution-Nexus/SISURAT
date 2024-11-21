<?php

namespace app\controllers\api;

use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\UserModel;


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

    public function Login() {
        // Membaca data JSON dari request body
        $jsonData = json_decode(file_get_contents("php://input"), true);
    
        // Memeriksa apakah data JSON valid
        if (!$jsonData) {
            // Mengirimkan respons error jika data tidak valid
            header('Content-Type: application/json');
            echo json_encode([
                "data" => [
                    "msg" => "Data tidak valid",
                    "status" => false
                ]
            ]);
            exit;
        }
    
        // Mengambil NIK dan password dari data yang dikirim
        $nik = $jsonData["nik"];
        $password = $jsonData["password"];
    
        // Mencari pengguna berdasarkan NIK
        $users = $this->model->UserModel->where("nik", "=", $nik)->first();
    
        // Menentukan respons berdasarkan apakah NIK ditemukan
        header('Content-Type: application/json'); // Menetapkan header untuk JSON
        if ($users) {
            // Jika pengguna ditemukan, memeriksa kecocokan password
            if (password_verify($password, $users->password)) {
                echo json_encode([
                    "data" => [
                        "msg" => "Login berhasil",
                        "status" => true,
                        "dataUserLogin" => $users->id
                    ]
                ]);
            } else {
                // Jika password tidak cocok
                echo json_encode([
                    "data" => [
                        "msg" => "Password salah",
                        "status" => false
                    ]
                ]);
            }
        } else {
            // Jika NIK tidak ditemukan
            echo json_encode([
                "data" => [
                    "msg" => "NIK belum terdaftar. Silakan lakukan registrasi terlebih dahulu",
                    "status" => false
                ]
            ]);
        }
    
        exit; // Menghentikan eksekusi script setelah mengirimkan respons
    }
    
    public function Veriv() {
        // Membaca data JSON dari request body
        $jsonData = json_decode(file_get_contents("php://input"), true);
    
        // Memeriksa apakah data JSON valid
        if (!$jsonData) {
            // Mengirimkan respons error jika data tidak valid
            header('Content-Type: application/json');
            echo json_encode([
                "msg" => "Data tidak valid"
            ]);
            exit;
        }
    
        // Mengambil NIK dari data yang dikirim
        $nik = $jsonData["nik"];
    
        // Mencari pengguna berdasarkan NIK
        $users = $this->model->UserModel->where("nik", "=", $nik)->first();
    
        // Menentukan respons berdasarkan apakah NIK ditemukan
        header('Content-Type: application/json'); // Menetapkan header untuk JSON
        if ($users) {
            // Jika pengguna ditemukan
            echo json_encode([
                "data" => [
                    "msg" => "Nik ditemukan",
                    "status" => true
                ]
            ]);
        } else {
            // Jika pengguna tidak ditemukan
            echo json_encode([
                "data" => [
                    "msg" => "Nik belum terdaftar",
                    "status" => false
                ]
            ]);
        }
    
        exit; // Menghentikan eksekusi script setelah mengirimkan respons
    }
    
    
    public function Aktivasi() {
        // Membaca data JSON dari request body
        $jsonData = json_decode(file_get_contents("php://input"), true);
    
        // Memeriksa apakah data JSON valid
        if (!$jsonData) {
            header('Content-Type: application/json');
            echo json_encode([
                "msg" => "Data tidak valid"
            ]);
            exit;
        }
    
        // Mengambil data dari JSON
        $nik = $jsonData["nik"] ?? null;
        $no_hp = $jsonData["no_hp"] ?? null;
        $password = $jsonData["password"] ?? null;
    
        // Validasi input
        if (empty($nik) || empty($no_hp) || empty($password)) {
            header('Content-Type: application/json');
            echo json_encode([
                "data" => [
                    "msg" => "Semua field wajib diisi.",
                    "status" => false
                ]
            ]);
            exit;
        }
    
        // Periksa apakah NIK ada di tabel masyarakat
        $users = $this->model->masyarakatModel->where("nik", "=", $nik)->first();
    
        header('Content-Type: application/json');
        if ($users) {
            // Periksa apakah NIK sudah diaktivasi
            $userExists = $this->model->UserModel->where("nik", "=", $nik)->first();
            if ($userExists) {
                echo json_encode([
                    "data" => [
                        "msg" => "NIK sudah diaktivasi sebelumnya. Silakan login.",
                        "status" => false
                    ]
                ]);
            } else {
                // Hash password sebelum menyimpan
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
                // Simpan data ke tabel users
                $this->model->UserModel->create([
                    "nik" => $nik,
                    "no_hp" => $no_hp,
                    "password" => $hashedPassword
                ]);
    
                echo json_encode([
                    "data" => [
                        "msg" => "Aktivasi berhasil. Silakan login.",
                        "status" => true
                    ]
                ]);
            }
        } else {
            // Jika NIK tidak ditemukan di data masyarakat
            echo json_encode([
                "data" => [
                    "msg" => "NIK tidak ditemukan di data masyarakat.",
                    "status" => false
                ]
            ]);
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

        // Validasi input
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

