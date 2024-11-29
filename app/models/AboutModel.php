<?php

namespace app\models;

use app\abstract\Model;

class AboutModel extends Model
{
    protected $table = "landing";  // Nama tabel
    protected $primaryKey = "id"; // Nama primary key
    protected $fillable = ["id", "nama_website", "judul_home", "deskripsi_home", "judul_tentang", "link_download", "tentang_aplikasi", "email_kelurahan", "no_telp", "alamat_kelurahan", "video_url"]; // Kolom yang bisa diisi

}
