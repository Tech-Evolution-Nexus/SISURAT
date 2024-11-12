<?php

namespace app\models;

use app\abstract\Model;

class UserModel extends Model
{
    protected $table = "users";  // Nama tabel
    protected $primaryKey = "id"; // Nama primary key
    protected $fillable = ["id", "email", "password", "no_hp", "role"]; // Kolom yang bisa diisi

    public function user()
    {
        $idUser = session()->get("user_id");
        $user = $this->where("id", "=", $idUser)->join("masyarakat", "users.nik", "masyarakat.nik")->first();
        return $user ?? null;
    }
    public function check()
    {
        $idUser = session()->get("user_id");
        $user = $this
            ->select("users.id,nama_lengkap,role,email")
            ->where("id", "=", $idUser)
            ->join("masyarakat", "users.nik", "masyarakat.nik")->first();
        return !!$user;
    }
}
