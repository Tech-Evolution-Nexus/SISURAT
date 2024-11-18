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
    public function Login(){
        $jsonData = json_decode(file_get_contents("php://input"), true);
        if (!$jsonData) {
            return response($jsonData, 200);
        }
        $nik = $jsonData["nik"];
        $password = $jsonData["password"];

        $users = $this->model->UserModel->where("nik", "=", $nik)->first();
        return response( $users,200);      
        if ($users) {

            if (password_verify($password, $users->password)) {
                return response(["data"=>["msg"=>"User ditemukan","dataUserLogin"=>$users->id,"status"=>true]],200);      
            } else {
                return response(["data"=>["msg"=>"Password salah","dataUserlogin"=>null,"status"=>false]],401);
            }
        } else {
            return response(["data"=>["msg"=>"User tidak Ditemukan","dataUserlogin"=>null,"status"=>false]],401);      
        }
    
    }

    

    public function Veriv(){
        $nik = request("nik");
        // return response($nik);
        $users = $this->model->masyarakatModel->where("nik", "=", $nik)->first();
        if(isset($users)){
            return response(["data"=>["msg"=>"Nik ditemukan","datanik"=>$users->nik,"status"=>true]],200);      
        }else{
            return response(["data"=>["msg"=>"Nik tidak ditemukan","datanik"=>null,"status"=>true]],401);      
        }

    }



    public function Aktivasi()
    {
        $nik = request("nik");
        $no_hp = request("no_hp");
        $password = request("password");
    
        // Validasi input
        if (empty($nik) || empty($no_hp) || empty($password)) {
            return response([
                "data" => [
                    "msg" => "Semua field wajib diisi.",
                    "status" => false,
                ]
            ], 400);
        }
    
        // Periksa apakah NIK ada di tabel masyarakat
        $users = $this->model->masyarakatModel->where("nik", "=", $nik)->first();

        if (isset($users)) {
            // Periksa apakah NIK sudah terdaftar di tabel users
            $userExists = $this->model->UserModel->where("nik", "=", $nik)->first();
            if ($userExists) {
                return response([
                    "datanik" => [
                        "msg" => "NIK sudah diaktivasi sebelumnya. Silakan login.",
                        "status" => false,
                    ]
                ], 409); // 409 = Conflict
            }
    
            // Hash password sebelum menyimpan
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    
            // Simpan data ke tabel users
            $this->model->UserModel->create([
                "nik" => $nik, // Ambil NIK dari masyarakat
                "no_hp" => $no_hp,
                "password" => $hashedPassword,
            ]);
    
            return response([
                "datanik" => [
                    "msg" => "Aktivasi berhasil. Silakan login.",
                    "redirectTo" => "login",
                    "status" => true,
                ]
            ], 201); // 201 = Created
        } else {
            return response([
                "data" => [
                    "msg" => "NIK tidak ditemukan di data masyarakat.",
                    "status" => false,
                ]
            ], 404); // 404 = Not Found
        }
    }
    
    public function Register()
    {
        $nik = request("nik");
        $password = request("password");
        $no_hp = request("no_hp");
        $nama_lengkap = request("nama_lengkap");
        $role = "masyarakat"; // Role default
        $jenis_kelamin = request("jenis_kelamin");
        $tempat_lahir = request("tempat_lahir");
        $tgl_lahir = request("tgl_lahir");
        $agama = request("agama");
        $pendidikan = request("pendidikan");
        $pekerjaan = request("pekerjaan");
        $status_perkawinan = request("status_perkawinan");
        $status_keluarga = request("status_keluarga");
        $kewarganegaraan = request("kewarganegaraan");
        $nama_ayah = request("nama_ayah");
        $nama_ibu = request("nama_ibu");
        $no_kk = request("no_kk");
        $alamat = request("alamat");
        $rt = request("rt");
        $rw = request("rw");
        $kode_pos = request("kode_pos");
        $kelurahan = request("kelurahan");
        $kecamatan = request("kecamatan");
        $kabupaten = request("kabupaten");
        $provinsi = request("provinsi");
        $kk_tgl = request("kk_tgl");
    
        // Validasi wajib diisi
        if (empty($nik) || empty($nama_lengkap) || empty($password) || empty($no_hp) || empty($no_kk)) {
            return response([
                "data" => [
                    "msg" => "Field NIK, nama lengkap, password, nomor HP, dan No KK wajib diisi.",
                    "status" => false,
                ]
            ], 400);
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
            "kk_tgl" => $kk_tgl,
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
            "no_kk" => $no_kk, // Relasi dengan tabel kartu keluarga
        ]);
    
        // Simpan data ke tabel user
        $this->model->UserModel->create([
            "nik" => $nik,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "no_hp" => $no_hp,
            "role" => $role,
        ]);
    
        // Kirim respons sukses
        return response([
            "data" => [
                "msg" => "Registrasi berhasil.",
                "status" => true,
            ]
        ], 201);
    }
    
    
    
}

