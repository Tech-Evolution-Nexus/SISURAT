<?php

namespace app\models;

use app\abstract\Model;

class LampiranPengajuanModel extends Model
{
    protected $primaryKey  = "id";
    protected $table  = "lampiran_pengajuan";
    protected $fillable = ["id_pengajuan","id_lampiran","url"];

}