<?php

namespace app\models;

use app\abstract\Model;

class FormatSuratModel extends Model
{
    protected $table = "format_surat";  // Nama tabel
    protected $primaryKey = "id"; // Nama primary key
    protected $fillable = ["id", "nama", "konten"]; // Kolom yang bisa diisi

}
