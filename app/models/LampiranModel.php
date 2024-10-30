<?php

namespace app\models;

use app\abstract\Model;

class LampiranModel extends Model
{
    protected $primaryKey  = "id";
    protected $table  = "lampiran";
    protected $fillable = ["nama_lampiran"];

}