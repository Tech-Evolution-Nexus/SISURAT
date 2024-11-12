<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;

class KomponenController extends Controller
{
    public function getImage($url){
        $filePath = __DIR__ . '/../../upload/' . $url;
        if (file_exists($filePath) && is_file($filePath)) {
            $mimeType = mime_content_type($filePath);
            header('Content-Type: ' . $mimeType);
            readfile($filePath);
            return;
        }
    }
}