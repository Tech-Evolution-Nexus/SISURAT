<?php

namespace app\models;

use app\interface\Model;

class UserModel extends Model
{

    public function create($data)
    {
        return  $this->insert("INSERT INTO users (email,password,no_hp,role,id_masyarakat,created_at) VALUES(:email,:password,:no_hp,:role,:id_masyarakat,:created_at)", $data);
    }
    public function cekuserbyemail($email){
        return $this->singleQuery("SELECT * FROM users WHERE email = '$email'")??false;
    }
    public function updatetokenreset($token,$expire,$email){
        return $this->update("UPDATE users SET reset_token = '$token', token_expire = '$expire' WHERE email = '$email'");
    }
}
