<?php

use app\models\UserModel;
use app\services\Redirector;
use app\services\Request;
use app\services\Session;

if (!function_exists("assets")) {
    function assets($path)
    {
        // Menggabungkan direktori public dengan jalur aset
        return baseUrl() . "/" . $path;
    }
}
if (!function_exists("storagePath")) {
    function storagePath($access = "public", $fileDir = "")
    {
        return ($access == "public" ? __DIR__ . "/../../public/" : __DIR__ . "/../../upload/") . ltrim($fileDir, "/");
    }
}


if (!function_exists("session")) {
    function session()
    {
        return new Session();
    }
}

if (!function_exists("baseUrl")) {
    function baseUrl()
    {
        // Dapatkan protokol (HTTP/HTTPS)
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';

        // Dapatkan nama host
        $host = $_SERVER['HTTP_HOST'];

        // Dapatkan direktori aplikasi jika ada
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        // Bangun base URL
        return "$protocol://$host$scriptName/";
    }
}


if (!function_exists("view")) {
    function view($path, $data = [])
    {
        $path = str_replace('.', '/', $path);

        // Ekstrak data yang dikirim ke view
        extract($data);
        include __DIR__ . "/../../view/$path.php";
    }
}

if (!function_exists("includeFile")) {
    function includeFile($path)
    {
        include __DIR__ . "/../../view/$path.php";
    }
}

if (!function_exists("request")) {
    function request($key = null)
    {
        $request = new Request();
        if (!$key) return $request;
        return $request->get($key) ?? null;
    }
}
if (!function_exists("redirect")) {
    function redirect($url = null)
    {
        $redirect = new Redirector();
        if (is_null($url)) return $redirect;
        $redirect->to($url);
        exit;
    }
}

if (!function_exists("old")) {
    function old($key, $default = "")
    {
        $session = new Session();
        return $session->flash($key) ?? $default;
    }
}

if (!function_exists("session")) {
    function session()
    {
        return  new Session();
    }
}
if (!function_exists("auth")) {
    function auth()
    {
        return  new UserModel();
    }
}



if (!function_exists("response")) {
    function response($data, $status = 200)
    {
        http_response_code($status); // Set status code
        header('Content-Type: application/json'); // Set content type
        echo json_encode($data); // Output JSON
        exit(); // Terminate script to prevent further output
    }
}
if (!function_exists("dd")) {
    function dd(...$data)
    {
        foreach ($data as $d) {
            echo '<pre>';
            var_dump($d);
            echo '</pre>';
            echo '<br/>';
        }
        die();
    }
}
if (!function_exists("url")) {
    function url($url)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $path = str_replace('/public', '', $path);
        return $protocol . $host . $path . '/' . ltrim($url, '/');
    }
}

if (!function_exists("formatStatusPengajuan")) {
    function formatStatusPengajuan($status)
    {
        switch ($status) {
            case 'di_terima_rw':
                return "Disetujui RW";
                break;
            case 'di_terima_rt':
                return "Disetujui RT";
                break;
            case 'di_tolak_rw':
                return "Ditolak RW";
                break;
            case 'di_tolak_rt':
                return "Ditolak RT";
                break;
            case 'selesai':
                return "Selesai";
                break;

            default:
                return "Selesai";
                break;
        }
    }
}

if (!function_exists("formatDate")) {
    function formatDate($date)
    {
        // Cek apakah tanggal valid dan tidak kosong
        if (!empty($date) && strtotime($date) !== false) {
            // Ubah nama bulan ke bahasa Indonesia
            $bulanIndonesia = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember'
            ];

            // Format tanggal ke bahasa Inggris terlebih dahulu
            $formattedDate = date('d F Y', strtotime($date));

            // Ganti bulan Inggris dengan bulan Indonesia
            return strtr($formattedDate, $bulanIndonesia);
        }

        // Kembalikan NULL jika tanggal tidak valid atau kosong
        return null;
    }
}



if (!function_exists("loadEnv")) {
    function loadEnv()
    {
        $file = __DIR__ . "/../../.env";

        if (!file_exists($file)) {
            // throw new Exception("The .env file does not exist.");
            return;
        }

        // Read the .env file line by line
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Remove comments
            $line = trim($line);
            if (strpos($line, '#') === 0) {
                continue;
            }

            // Split the line into key and value
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // Remove surrounding quotes if present
            if ((strlen($value) > 1 && $value[0] === '"' && $value[-1] === '"') ||
                (strlen($value) > 1 && $value[0] === "'" && $value[-1] === "'")
            ) {
                $value = substr($value, 1, -1);
            }

            // Set the environment variable
            putenv("$key=$value");
            $_ENV[$key] = $value; // Optionally, you can store it in $_ENV as well
        }
    }
}
