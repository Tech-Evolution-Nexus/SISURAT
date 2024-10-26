<?php

namespace app\models;

use app\interface\Model;

class UserModel extends Model
{

    public function create($data)
    {
        return  $this->execute("INSERT INTO users (email,password,no_hp,role,id_masyarakat,created_at) VALUES(:email,:password,:no_hp,:role,:id_masyarakat,:created_at)", $data);
    }
    public function cekuserbyemail($email){
        return $this->singleQuery("SELECT * FROM users WHERE email = '$email'")??false;
    }
    public function updatetokenreset($data){
        return $this->execute("UPDATE users SET token_reset = :token WHERE email = :email",$data);
    }
    public function cekresettoken($token){
        return $this->singleQuery("SELECT * FROM users WHERE token_reset = '$token'")??false;
    }
}
