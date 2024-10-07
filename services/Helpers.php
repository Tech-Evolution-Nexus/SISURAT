<?php

if (!function_exists("assets")) {
    function assets($path)
    {
        // Menggabungkan direktori public dengan jalur aset
        return baseUrl() . "/" . $path;
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
        extract($data);
        include __DIR__ . "/../view/$path.php";
    }
}

if (!function_exists("includeFile")) {
    function includeFile($path)
    {
        include __DIR__ . "/../view/$path.php";
    }
}



if (!function_exists("loadEnv")) {
    function loadEnv()
    {
    $file = __DIR__ .".env";
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
            (strlen($value) > 1 && $value[0] === "'" && $value[-1] === "'")) {
            $value = substr($value, 1, -1);
        }

        // Set the environment variable
        putenv("$key=$value");
        $_ENV[$key] = $value; // Optionally, you can store it in $_ENV as well
    }
}
}