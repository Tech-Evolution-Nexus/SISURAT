<?php

namespace app\services;

use PDO;
use PDOException;

class Database
{
    private $conn;                     // Variabel untuk menyimpan koneksi PDO

    // Konstruktor kelas, akan dijalankan saat objek dibuat
    public function __construct()
    {
        // Parameter koneksi database
        // $servername = getenv("DB_HOST"); // Nama server database
        // $username =  getenv("DB_USERNAME");        // Nama pengguna database
        // $password =  getenv("DB_PASSWORD");       // Kata sandi pengguna database
        // $dbName =  getenv("DB_NAME");       // Nama database

        $servername = "localhost";
        $username = "admin";
        $password = "101010";
        $dbName = "badean_post";
        try {
            // Mencoba membuat koneksi ke database menggunakan PDO
            $this->conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);

            // Set atribut error mode menjadi Exception untuk menangani kesalahan
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Menangani error jika koneksi gagal
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // Metode untuk mendapatkan koneksi database
    public function getConnection()
    {
        return $this->conn;
    }
}
