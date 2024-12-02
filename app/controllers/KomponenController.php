<?php

namespace app\controllers;

use app\abstract\Controller;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;

class KomponenController extends Controller
{
    public function getImageSurat($url)
    {
        $filePath = __DIR__ . '/../../upload/surat/' . $url;
        $this->proses($filePath);
    }
    public function getImageBerita($url)
    {
        $filePath = __DIR__ . '/../../upload/berita/' . $url;
        $this->proses($filePath);
    }
    public function getImageKartuKeluarga($url)
    {
        $filePath = __DIR__ . '/../../upload/kartu_keluarga/' . $url;
        $this->proses($filePath);
    }
    public function getImageMasyarakat($url)
    {
        $filePath = __DIR__ . '/../../upload/masyarakat/' . $url;
        $this->proses($filePath);
    }
    public function getImageverif($url)
    {
        $filePath = __DIR__ . '/../../upload/fileverif/' . $url;
        $this->proses($filePath);
    }
    private function proses($filePath = "")
    {
        if (file_exists($filePath) && is_file($filePath)) {
            $mimeType = mime_content_type($filePath);
            header('Content-Type: ' . $mimeType);
            readfile($filePath);
            return;
        }
    }

    public function getImageLampiran($url)
    {
        $filePath = __DIR__ . '/../../upload/lampiran/' . $url;
        if (file_exists($filePath) && is_file($filePath)) {
            $mimeType = mime_content_type($filePath);
            header('Content-Type: ' . $mimeType);
            readfile($filePath);
            return;
        }
    }
}
