<?php

namespace app\models;

use app\abstract\Model;

class JenisSuratModel extends Model
{
    protected $primaryKey  = "id";
    protected $table  = "surat";
    protected $fillable = ["nama_surat","image"];
    // public function all()
    // {
    //     return  $this->query("SELECT * FROM surat ");
    // }
}