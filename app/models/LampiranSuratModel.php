<?php

namespace app\models;

use app\abstract\Model;

class LampiranSuratModel extends Model
{
    protected $primaryKey  = "id";
    protected $table  = "lampiran_surat";
    protected $fillable = ["id_surat","id_lampiran"];

}