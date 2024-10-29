<?php

namespace app\models;

use app\abstract\Model;

class JenisSuratModel extends Model
{
    public function all()
    {
        return  $this->query("SELECT * FROM surat ");
    }
}