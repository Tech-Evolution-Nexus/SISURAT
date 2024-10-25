<?php
// Fungsi rekursif untuk menghitung faktorial
function faktorial($n) {
    // Kondisi dasar: jika n <= 1, return 1
    if ($n <= 1) {
        return 1;
    }
    // Rekursi: n * faktorial(n - 1)
    return $n * faktorial($n - 1);
}

// Contoh penggunaan
$angka = 5;
echo "Faktorial dari " . $angka . " adalah: " . faktorial($angka);
?>
