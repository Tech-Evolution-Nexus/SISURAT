<?php

namespace app\services;

use Exception;

class Route
{
    // Deklarasikan variabel routes sebagai statis
    private static $routes = [];

    // Method create dengan parameter yang benar
    public static function addRoute($method = "GET", $url = "/", $action = null)
    {
        // Validasi metode HTTP
        $method = strtoupper($method);
        if (!in_array($method, ["GET", "POST"])) {
            throw new \InvalidArgumentException("Method must be GET or POST");
        }

        // Pastikan URL dan action disediakan
        if (empty($url) || $action === null) {
            throw new \InvalidArgumentException("URL and action must be provided");
        }

        // Simpan aksi rute
        self::$routes[$method][rtrim($url, "/")] = $action;
        return new self;
    }

    public static function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = rtrim($_SERVER['REQUEST_URI'], "/");

        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $routeUrl => $target) {
                // $pattern = preg_replace('/\/:([^\/]+)/', '/(?P<$1>[^/]+)', $routeUrl);
                $pattern = preg_replace('/\/:(\w+)/', '/(?P<$1>[^/]+)', $routeUrl);

                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    if (is_array($target)) {
                        $class = $target[0];
                        $method = $target[1];
                        if (class_exists($class) && method_exists($class, $method)) {
                            $instance = new $class();
                            call_user_func_array([$instance, $method], $params);
                            return;
                        } else {
                            throw new Exception("Class or method not found");
                        }
                    } else if (is_callable($target)) {
                        call_user_func_array($target, $params);
                        return;
                    } else {
                        throw new Exception("Target is not callable");
                    }
                }
            }
        }
        throw new Exception('Route not found');
    }
}
