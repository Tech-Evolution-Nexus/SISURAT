<?php

class person
{ // Mendefinisikan kelas 'person' yang merepresentasikan seseorang.

    var $name; // Deklarasi properti 'name' untuk menyimpan nama orang.

    function __construct($persons_name)
    { // Konstruktor kelas yang dipanggil saat objek dibuat.
        echo "<p>initialize class</p>"; // Menampilkan pesan ketika kelas diinisialisasi.
    }

    function set_name($new_name)
    { // Metode untuk menetapkan nilai pada properti 'name'.
        $this->name = $new_name; // Menggunakan '$this' untuk mengakses properti 'name' dan mengisinya dengan nilai '$new_name'.
    }


    function get_name()
    { // Metode untuk mendapatkan nilai properti 'name'.
        return $this->name; // Mengembalikan nilai dari properti 'name'.
    }

    function __destruct()
    { // Destructor kelas yang dipanggil saat objek dihancurkan atau eksekusi selesai.
        echo "<p>end class</p>"; // Menampilkan pesan ketika kelas berakhir.
    }
}
