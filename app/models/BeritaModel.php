<?php

namespace app\models;

use app\abstract\Model;

class BeritaModel extends Model
{
    protected $primaryKey  = "id";
    protected $table  = "berita";
    protected $fillable = ["judul", "sub_judul", "deskripsi", "gambar", "created_at", "updated_at"];
}