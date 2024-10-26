<?php
// ini merupakan main file yang memanggil file lainnya

session_start();

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
require '../lib/PHPMailer/PHPMailer.php';
require '../lib/PHPMailer/SMTP.php';
require '../lib/PHPMailer/Exception.php';
// memanggil file lainnya
include __DIR__ . "/../app/services/Helpers.php";
include __DIR__ . "/../app/services/httpstatusview/statuscollection.php";
loadEnv();
include __DIR__ . "/../route/route.php";
