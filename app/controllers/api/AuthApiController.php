<?php

namespace app\controllers\api;

use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use app\models\UserModel;
use Exception;
use FileUploader;
use PHPMailer\PHPMailer\PHPMailer;

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
            $users = $this->model->UserModel->select("masyarakat.nik,password,role,masyarakat.no_kk,masyarakat.nama_lengkap")->join("masyarakat", "masyarakat.nik", "users.nik")->where("users.nik", "=", $nik)->where("users.status", "=", 1)->first();
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
        header("Access-Control-Allow-Origin: *");
        $jsonData = json_decode(file_get_contents('php://input'), true);
        $dataJson = request("data");
        $dataJson = html_entity_decode($dataJson);
        $data = json_decode($dataJson);
        $img = request("images");

        $nik = $data->nik;
        $agama = $data->agama;
        $alamat = $data->alamat;
        $email = $data->email;
        $jenis_kelamin = $data->jenis_kelamin;
        $kabupaten = $data->kabupaten;
        $kecamatan = $data->kecamatan;
        $kelurahan = $data->kelurahan;
        $kewarganegaraan = $data->kewarganegaraan;
        $kk_tgl = $data->kk_tgl;
        $kode_pos = $data->kode_pos;
        $nama_ayah = $data->nama_ayah;
        $nama_ibu = $data->nama_ibu;
        $nama_lengkap = $data->nama_lengkap;
        $no_hp = $data->no_hp;
        $no_kk = $data->no_kk;
        $password = $data->password;
        $pekerjaan = $data->pekerjaan;
        $pendidikan = $data->pendidikan;
        $provinsi = $data->provinsi;
        $rt = $data->rt;
        $rw = $data->rw;
        $status_keluarga = $data->status_keluarga;
        $status_perkawinan = $data->status_perkawinan;
        $tempat_lahir = $data->tempat_lahir;
        $tgl_lahir = $data->tgl_lahir;

        if (empty($nik) || empty($nama_lengkap) || empty($password) || empty($no_hp) || empty($no_kk)) {
            return response([
                "message" => "Field NIK, nama lengkap, password, nomor HP, dan No KK wajib diisi.",
                "status" => false,
                "data" => []
            ], 400);
        }

        $cekstatuskk = $this->model->masyarakatModel->where("no_kk", "=", $no_kk)->where("status_keluarga", "=", "kk")->first();
        if ($cekstatuskk) {
            return response([
                "message" => "Gagal Kepala Keluarga Sudah Terdaftar.",
                "status" => false,
                "data" => []
            ], 200);
        } else {
            $cekkk = $this->model->KartuKeluargaModel->where("no_kk", "=", $no_kk)->first();
            $fileName = $img['name'];
            $fileTmpName = $img['tmp_name'];
            $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowedFileTypes = ["jpg", "jpeg", "png", "gif", "bmp", "webp", "svg"];
            $nameFile  = uniqid() . "." . $fileExt;
            if ($cekkk) {
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
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $this->model->UserModel->create([
                    "nik" => $nik,
                    "email" => $email,
                    "password" => $hashedPassword,
                    "no_hp" => $no_hp,
                    "role" => "masyarakat"
                ]);
            } else {
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
                    "kk_file" => $nameFile
                ]);
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
                    "no_kk" => $no_kk,
                    "kk_file" => $nameFile
                ]);
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $this->model->UserModel->create([
                    "nik" => $nik,
                    "email" => $email,
                    "password" => $hashedPassword,
                    "no_hp" => $no_hp,
                    "role" => "masyarakat"
                ]);
            }

            $uploader = new FileUploader();
            $uploader->setFile($fileTmpName);
            $uploader->setTarget(storagePath("private", "/fileverif/" . $nameFile));
            $uploader->setAllowedFileTypes($allowedFileTypes);
            $uploadStatus = $uploader->upload();
            if ($uploadStatus !== true) {
                return response(["status" => false, "message" => "Gagal Menambahkan Data eeror image", "data" => $uploadStatus], 200);
            }
        }
        return response([
            "message" => "Registrasi berhasil.",
            "status" => true,
            "data" => []
        ], 200);
    }
    public function sendemail()
    {
        $email = request('email');
        $model  = new UserModel();
        $result = $this->model->UserModel->where("email", "=", $email)->first();
        if ($result) {
            // Buat token
            $token = bin2hex(random_bytes(50)); // Generate random token
            $expiry = time() + 3600; // 1 jam ke depan
            $payload = json_encode(['email' => $email, 'token' => $token, 'exp' => $expiry]);
            $encodedToken = base64_encode($payload);
            $data = [
                "token_reset" => $encodedToken,
                "email" => $email
            ];


            $resetLink = "http://192.168.100.205/SISURAT/api/reset-password?token=" . $encodedToken;
            $mail = new PHPMailer(true);
            try {
                // Pengaturan server SMTP
                $mail->isSMTP();
                $mail->Host = $_ENV['MAIL_HOST']; // Ganti dengan server SMTP Anda
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_USERNAME']; // Ganti dengan email Anda
                $mail->Password = $_ENV['MAIL_PASSWORD']; // Ganti dengan password email Anda
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // atau PHPMailer::ENCRYPTION_SMTPS
                $mail->Port = 587; // Ganti dengan port yang sesuai

                // Penerima
                $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
                $mail->addAddress($email); // Tambahkan alamat email penerima

                // Konten email
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body = "Klik tautan ini untuk reset password Anda:
                    <br><br>
                    <a href='{$resetLink}' style='display: inline-block; padding: 10px 20px; font-size: 16px; color: white; background-color: #007BFF; text-decoration: none; border-radius: 5px;'>Reset Password</a>
                    ";

                // Kirim email
                if ($mail->send()) {
                    $this->model->UserModel->where("id", "=", $result->id)->update($data);
                };
                return response([
                    "message" => "Email Berhasil Dikirim.",
                    "status" => true,
                    "data" => []
                ], 200);
            } catch (Exception $e) {
                return response([
                    "message" => "Email Gagal Dikirim.",
                    "status" => true,
                    "data" => []
                ], 400);
            }
        } else {
            return response([
                "message" => "Email Tidak Ditemukan",
                "status" => false,
                "data" => []
            ], 200);
        }
    }
    public function resetpassword()
    {
        $email = request("email");
        $token = request("token");
        $password = request("password");

        // Encrypt password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        if (!$token || !$email || !$password) {
            return redirect()->with("error", "Email,Password,Token Tidak Ada.")->back();
        }

        $dataupdate = [
            "password" => $hashed_password,
            "token_reset" => null
        ];

        $result = $this->model->UserModel->where("email", "=", $email)->first();
        $data = json_decode(base64_decode($result->token_reset));
        if ($result) {
            if (time() > $data->exp) {
                return response([
                    "message" => "Token Sudah Kadaluarsa",
                    "status" => false,
                    "data" => []
                ], 200);
            } else {
                if ($token == $data->token) {
                    if ($this->model->UserModel->where("email", "=", $data->email)->update($dataupdate)) {
                        return response([
                            "message" => "Password Berhasil Direset.",
                            "status" => true,
                            "data" => []
                        ], 200);
                    }else{
                        return response([
                            "message" => "Password Gagal Direset.",
                            "status" => false,
                            "data" => []
                        ], 200);
                    }
                } else {
                    return response([
                        "message" => "Token tidak ditemukan",
                        "status" => false,
                        "data" => []
                    ], 200);
                }
            }
        } else {
            return response([
                "message" => "User Tidak Ditemukan",
                "status" => false,
                "data" => []
            ], 200);
        }
    }

    public function gantipassword()
    {
        $nik = request("nik");
        $password = request("password");
        $new_pass = request("new_password");
        

        // Encrypt password
        $hashed_password = password_hash($new_pass, PASSWORD_BCRYPT);

        $nik = 
        $user = $this->model->UserModel->where("nik", "=", $nik)->first();
        if ($user) {
            if (password_verify($password,$user->password)) {
                $this->model->userModel->where("nik", "=", $nik)->update(["password" => $hashed_password]);
                return response([
                    "message" => "Password berhasil diubah",
                    "status" => true,
                    "data" => []
                ], 200);
        }
        

    }
}
}