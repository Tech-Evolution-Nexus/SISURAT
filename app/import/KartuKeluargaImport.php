<?php

namespace app\import;

use app\abstract\ImportExcel;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
use Exception;

class KartuKeluargaImport extends ImportExcel
{

    public function run(array $data)
    {
        // dd($data);
        try {
            $dataKK = [
                "no_kk" => $data["no_kk"],
                "alamat" => $data["alamat"],
                "rt" => $data["rt"],
                "rw" => $data["rw"],
                "kode_pos" => $data["kode_pos"],
                "kelurahan" => $data["kelurahan"],
                "kecamatan" => $data["kecamatan"],
                "kabupaten" => $data["kabupaten"],
                "provinsi" => $data["provinsi"],
                "kk_tgl" => $data["tanggal_kk"]
            ];
            $kkModel = new KartuKeluargaModel();
            $kkExist =  $kkModel->where("no_kk", "=", $data["no_kk"])->first();
            $dataMasyarakat = [
                "nik" => $data["nik"],
                "nama_lengkap" => $data["nama_lengkap"],
                "jenis_kelamin" => $data["jenis_kelamin"],
                "tempat_lahir" => $data["tempat_lahir"],
                "tgl_lahir" => $data["tanggal_lahir"],
                "agama" => $data["agama"],
                "pendidikan" => $data["pendidikan"],
                "pekerjaan" => $data["pekerjaan"],
                "golongan_darah" => $data["golongan_darah"],
                "status_perkawinan" => $data["status_perkawinan"],
                "tgl_perkawinan" => $data["tanggal_perkawinan"],
                "status_keluarga" => $data["status_keluarga"],
                "kewarganegaraan" => $data["kewarganegaraan"],
                "nama_ayah" => $data["nama_ayah"],
                "nama_ibu" => $data["nama_ibu"],
                "no_kk" => $data["no_kk"]
            ];
            if ($kkExist) {
                $dataMasyarakat["no_kk"] = $kkExist->no_kk;
            } else {
                $id =  $kkModel->create($dataKK);
                $dataMasyarakat["no_kk"] = $id;
            }

            $masyarakatModel = new MasyarakatModel();
            $nikExist = $masyarakatModel->where("nik", "=", $data["nik"])->first();
            if ($nikExist) {
                return throw new Exception("Nik sudah terdaftar", 400);
            }
            $masyarakatModel->create($dataMasyarakat);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
