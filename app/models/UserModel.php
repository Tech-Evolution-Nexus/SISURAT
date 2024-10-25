<?php

namespace app\models;

use app\interface\Model;

class UserModel extends Model
{

    public function create($data)
    {
        return  $this->insert("INSERT INTO users (email,password,no_hp,role,id_masyarakat,created_at) VALUES(:email,:password,:no_hp,:role,:id_masyarakat,:created_at)", $data);
    }
}
