<?php

namespace app\models;

use app\services\Database;

class UserModel
{
    private $db;
    protected $table = 'users'; // Nama tabel

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(); // Mengembalikan semua pengguna
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (email, password, no_hp, role, id_masyarakat, created_at) VALUES (:email, :password, :no_hp, :role, :id_masyarakat, :created_at)");
        return $stmt->execute($data); // Mengembalikan true jika berhasil
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET email = :email, password = :password, no_hp = :no_hp, role = :role, id_masyarakat = :id_masyarakat, created_at = :created_at WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(); // Mengembalikan pengguna
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]); // Mengembalikan true jika berhasil
    }
}
