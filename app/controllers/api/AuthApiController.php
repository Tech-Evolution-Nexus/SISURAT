<?php

namespace app\controllers\api;

use app\models\JenisSuratModel;
use app\models\KartuKeluargaModel;
use app\models\LampiranSuratModel;
use app\models\MasyarakatModel;
use app\models\PengajuanSuratModel;
use app\models\UserModel;
use app\services\Database;
use PDO;
use Exception;

class AuthApiController
{

    private $model;
    public function __construct()
    {
        $this->model =  (object)[];
        $this->model->UserModel = new UserModel();
        $this->model->masyarakatModel = new MasyarakatModel();
    }
    public function Login(){
        $nik = request("nik");
        $password = request("password");
        
        $users = $this->model->UserModel->where("nik", "=", $nik)->first();

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

    

    public function veriv(){
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
        $nama_lengkap = request("nama_lengkap");
        $jenis_kelamin = request("jenis_kelamin");
        $tempat_lahir = request("tempat_lahir");
        $tgl_lahir = request("tgl_lahir");
        $agama = request("agama");
        $pendidikan = request("pendidikan");
        $pekerjaan = request("pekerjaan");
        $golongan_darah = request("golongan_darah");
        $status_perkawinan = request("status_perkawinan");
        $status_keluarga = request("status_keluarga");
        $kewarganegaraan = request("kewarganegaraan");
        $nama_ayah = request("nama_ayah");
        $nama_ibu = request("nama_ibu");
        $email = request("email");
        $password = request("password");
        $no_hp = request("no_hp"); 
        $no_kk = request("no_kk");

        if (empty($nik) || empty($nama_lengkap) || empty($email) || empty($password)) {
            return response([
                "data" => [
                    "msg" => "Field NIK, nama lengkap, email, dan password wajib diisi.",
                    "status" => false,
                ]
            ], 400);
        }

        $this->model->masyarakatModel->create([
            "nik" => $nik,
            "nama_lengkap" => $nama_lengkap,
            "jenis_kelamin" => $jenis_kelamin,
            "tempat_lahir" => $tempat_lahir,
            "tgl_lahir" => $tgl_lahir,
            "agama" => $agama,
            "pendidikan" => $pendidikan,
            "pekerjaan" => $pekerjaan,
            "golongan_darah" => $golongan_darah,
            "status_perkawinan" => $status_perkawinan,
            "status_keluarga" => $status_keluarga,
            "kewarganegaraan" => $kewarganegaraan,
            "nama_ayah" => $nama_ayah,
            "nama_ibu" => $nama_ibu,
            "no_kk" =>$no_kk,
            
        ]);

        $this->model->UserModel->create([
            "nik" => $nik,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "no_hp" => $no_hp,
            "role" => "masyarakat",     
           ]);

        return response(["data" => ["msg" => "Registrasi berhasil.","status" => true,]], 201);
    }

    
}

