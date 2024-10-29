<?php

namespace app\models;

use app\abstract\Model;

class RT_RWModel extends Model
{


    public function all($role)
    {
        return  $this->query("SELECT nama_lengkap,masyarakat.id,kartu_keluarga.rw as rw,kartu_keluarga.rt as rt,nik FROM masyarakat 
        JOIN kartu_keluarga ON masyarakat.id_kk = kartu_keluarga.id 
        JOIN users ON masyarakat.id = users.id_masyarakat 
        WHERE role='$role'
        ORDER BY masyarakat.id DESC");
    }
    public function create($data)
    {
        return $this->insert("INSERT INTO users (rt_pimpin,rw_pimpin,id_masyarakat,created_at) 
        VALUES(:rt_pimpin,:rw_pimpin,:id_masyarakat,:created_at)", $data);
    }

    public function cek($role, $rw, $rt, $nik)
    {
        return  $this->singleQuery("SELECT nama_lengkap,masyarakat.id,kartu_keluarga.rw as rw,kartu_keluarga.rt as rt,nik FROM masyarakat 
        JOIN kartu_keluarga ON masyarakat.id_kk = kartu_keluarga.id 
        JOIN users ON masyarakat.id = users.id_masyarakat 
        WHERE role='$role' AND  kartu_keluarga.rw = '$rw' AND  kartu_keluarga.rt = '$rt' AND nik = '$nik' 
        ORDER BY masyarakat.id DESC");
    }

    public function getById($id, $role)
    {
        return  $this->singleQuery("SELECT nama_lengkap,no_hp,masyarakat.id,kartu_keluarga.rw as rw,kartu_keluarga.rt as rt,nik FROM masyarakat 
        JOIN kartu_keluarga ON masyarakat.id_kk = kartu_keluarga.id 
        JOIN users ON masyarakat.id = users.id_masyarakat 
        WHERE role='$role'
        AND masyarakat.id = $id 
        ORDER BY masyarakat.id DESC");
    }
}
