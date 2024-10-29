<?php
// ini merupakan main file yang memanggil file lainnya
use app\services\Router;
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
include __DIR__ . "/../app/services/FileUploader.php";
include __DIR__ . "/../app/services/Helpers.php";
include __DIR__ . "/../app/services/httpstatusview/statuscollection.php";

loadEnv();
Router::$prefix = '/api'; // Menambahkan prefix untuk API
require_once '../route/api.php'; // Memuat rute API
Router::$prefix = ''; // Reset prefix untuk rute web
require_once '../route/web.php'; // Memuat rute web
