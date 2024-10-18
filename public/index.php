<?php
// ini merupakan main file yang memanggil file lainnya



//untuk otomatis inlcude file yg pemanggilannya menggunakan use
function autoload($class)
{
    $filePath = str_replace('\\', '/', $class) . '.php';
    $filePath = "../" . $filePath;
    if (file_exists($filePath)) {
        include_once($filePath);
    }
}

spl_autoload_register('autoload');

// memanggil file lainnya
include __DIR__ . "/../app/services/Helpers.php";
include __DIR__ . "/../route/route.php";
loadEnv();
