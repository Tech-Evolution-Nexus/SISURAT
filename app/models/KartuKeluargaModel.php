<?php

namespace app\models;

use app\interface\Model;

class KartuKeluargaModel extends Model
{
    protected $primaryKey  = "id";
    protected $table  = "kartu_keluarga";
    protected $fillable = ["no_kk", "alamat", "rt", "rw", "kode_pos", "kelurahan", "kecamatan", "kabupaten", "provinsi", "kk_tgl"];



    // public function all()
    // {
    //     return  $this->query("SELECT kartu_keluarga.id,no_kk,nama_lengkap,alamat,rw,rt FROM kartu_keluarga JOIN masyarakat ON  kartu_keluarga.id = masyarakat.id_kk WHERE status_keluarga = 'Kepala Keluarga' ORDER BY kartu_keluarga.id DESC");
    // }
    // public function getByIdKK($id)
    // {
    //     return  $this->singleQuery("SELECT kartu_keluarga.id,no_kk,nik,nama_lengkap ,alamat,rw,rt,masyarakat.id as id_masyarakat FROM kartu_keluarga JOIN masyarakat ON  kartu_keluarga.id = masyarakat.id_kk WHERE status_keluarga = 'Kepala Keluarga'  AND kartu_keluarga.id = '$id' LIMIT 1");
    // }

    // public function getByNoKKAndNik($noKK, $nik)
    // {
    //     return  $this->singleQuery("SELECT kartu_keluarga.id,no_kk,nik,nama_lengkap ,alamat,rw,rt,masyarakat.id as id_masyarakat FROM kartu_keluarga JOIN masyarakat ON  kartu_keluarga.id = masyarakat.id_kk WHERE status_keluarga = 'Kepala Keluarga'  AND kartu_keluarga.no_kk = '$noKK' AND masyarakat.nik = '$nik' LIMIT 1");
    // }

    // public function updateKartuKeluarga($data)
    // {
    //     return  $this->singleQuery("SELECT kartu_keluarga.id,no_kk,nik,nama_lengkap ,alamat,rw,rt,masyarakat.id as id_masyarakat FROM kartu_keluarga JOIN masyarakat ON  kartu_keluarga.id = masyarakat.id_kk WHERE status_keluarga = 'Kepala Keluarga'  LIMIT 1");
    // }
}
