<?php

namespace app\models;

use app\abstract\Model;

class MasyarakatModel extends Model
{
    protected $table = "masyarakat";  // Nama tabel
    protected $primaryKey = "id"; // Primary key
    protected $fillable = [
        "nik", "nama_lengkap", "jenis_kelamin", "tempat_lahir", 
        "tgl_lahir", "agama", "pendidikan", "pekerjaan",
        "golongan_darah", "status_perkawinan", "status_keluarga", 
        "kewarganegaraan", "nama_ayah", "nama_ibu", 
        "email", "no_hp","no_kk"
    ];
}
