<?php

namespace app\models;

use app\abstract\Model;

class ProfilModel extends Model
{
    protected $table = "users";  // Nama tabel
    protected $primaryKey = "id"; // Nama primary key
    protected $fillable = ["email", "password", "no_hp"]; // Kolom yang bisa diisi

}
