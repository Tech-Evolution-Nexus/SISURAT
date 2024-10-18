<?php

namespace app\models;

use app\interface\Model;

class KartuKeluargaModel extends Model
{

    public function all()
    {
        return  $this->query("SELECT no_kk,nama_lengkap,alamat,rw,rt FROM kartu_keluarga JOIN masyarakat ON  kartu_keluarga.id = masyarakat.id_kk WHERE status_keluarga = 'Kepala Keluarga' ORDER BY kartu_keluarga.id DESC");
    }
}
