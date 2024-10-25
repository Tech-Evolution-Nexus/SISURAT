<?php

namespace app\models;

use app\interface\Model;

class UserModel extends Model
{

    public function create($data)
    {
        return  $this->insert("INSERT INTO users (email,password,no_hp,role,id_masyarakat,created_at) VALUES(:email,:password,:no_hp,:role,:id_masyarakat,:created_at)", $data);
    }
    public function update($id, $data)
    {
        $sql = "UPDATE users 
            SET email = :email, password = :password, no_hp = :no_hp, role = :role, id_masyarakat = :id_masyarakat, created_at = :created_at 
            WHERE id = :id";
        $data['id'] = $id;
        return parent::update($sql, $data);
    }

    public function getById() {}
    public function getByIdMasyarakat($idMasyarakat)
    {
        return  $this->singleQuery("SELECT nama_lengkap,masyarakat.id,kartu_keluarga.rw as rw,kartu_keluarga.rt as rt,nik FROM masyarakat 
        JOIN kartu_keluarga ON masyarakat.id_kk = kartu_keluarga.id 
        JOIN users ON masyarakat.id = users.id_masyarakat 
        WHERE masyarakat.id = $idMasyarakat
        ORDER BY masyarakat.id DESC");
    }
}