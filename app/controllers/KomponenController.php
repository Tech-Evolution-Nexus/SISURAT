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
        $filePath = __DIR__ . '/../../upload/kartu_keluarga/' . $url;
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
    public function getImageprofile($url)
    {
        $filePath = __DIR__ . '/../../public/assets/' . $url;
        $this->proses($filePath);
    }
    public function downloadapk(){   
        $file_path = __DIR__ . '/../../upload/esurat-badean.apk';

        if (file_exists($file_path)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/vnd.android.package-archive');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));

            readfile($file_path);
            exit;
        } else {
            echo "File tidak ditemukan.";
        }

    }
}
