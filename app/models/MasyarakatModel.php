<?php

namespace app\models;

use app\abstract\Model;

class MasyarakatModel extends Model
{


    public function getUnconnectedMasyarakatToKepalaKeluarga()
    {
        return  $this->query("SELECT nama_lengkap,id FROM  masyarakat WHERE status_keluarga = 'Kepala Keluarga' ORDER BY id DESC");
    }

    public function masyarakatActive()
    {
        return  $this->query("SELECT nama_lengkap,masyarakat.id,nik FROM  masyarakat LEFT JOIN users ON masyarakat.id = users.id_masyarakat   WHERE (users.id_masyarakat IS NOT NULL AND users.role = 'masyarakat') OR users.id_masyarakat IS NULL ORDER BY masyarakat.id DESC;");
    }
    public function getMasyarakatId($id)
    {
        return  $this->singleQuery("SELECT nama_lengkap,masyarakat.id,nik,alamat,rt,rw,no_hp FROM  masyarakat JOIN kartu_keluarga ON masyarakat.id_kk =kartu_keluarga.id  LEFT JOIN users ON 
        masyarakat.id = users.id_masyarakat   WHERE (users.id_masyarakat IS NOT NULL AND users.role = 'masyarakat') OR users.id_masyarakat IS NULL AND masyarakat.id = $id ORDER BY masyarakat.id  DESC;");
    }
}
