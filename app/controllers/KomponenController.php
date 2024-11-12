<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;

class KomponenController extends Controller
{
    public function getImageSurat($url){
        $filePath = __DIR__ . '/../../upload/surat/' . $url;
        if (file_exists($filePath) && is_file($filePath)) {
            $mimeType = mime_content_type($filePath);
            header('Content-Type: ' . $mimeType);
            readfile($filePath);
            return;
        }
    }
    public function getImageBerita($url){
        $filePath = __DIR__ . '/../../upload/berita/' . $url;
        if (file_exists($filePath) && is_file($filePath)) {
            $mimeType = mime_content_type($filePath);
            header('Content-Type: ' . $mimeType);
            readfile($filePath);
            return;
        }
    }
}