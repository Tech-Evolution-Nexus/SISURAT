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
        $servername = $_ENV["DB_HOST"]; // Nama server database
        $username =   $_ENV["DB_USERNAME"];        // Nama pengguna database
        $password =   $_ENV["DB_PASSWORD"];       // Kata sandi pengguna database
        $dbName =   $_ENV["DB_NAME"];       // Nama database

        // var_dump($_ENV);
        $servername = "localhost";
        $username = "root";
        $password = "";
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
