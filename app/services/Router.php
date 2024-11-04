<?php

namespace app\services;

use Exception;

class Router
{
    // Deklarasikan variabel routes sebagai statis
    private static $routes = [];
    public static $prefix = '';
    // Method create dengan parameter yang benar
    public static function addRoute($method = "GET", $url = "/", $action = null)
    {
        // Validasi metode HTTP
        $method = strtoupper($method);
        if (!in_array($method, ["GET", "POST"])) {
            show400();
            throw new \InvalidArgumentException("Method must be GET or POST");
        }

        // Pastikan URL dan action disediakan
        if (empty($url) || $action === null) {
            show400();
            throw new \InvalidArgumentException("URL and action must be provided");
        }

        // Simpan aksi rute
        $prefixedUrl = self::$prefix . rtrim($url, "/");
        self::$routes[$method][$prefixedUrl] = $action;
    }
    public static function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = rtrim($_SERVER['REQUEST_URI'], "/");
        $url = strtok($url, '?'); // Remove query string for matching routes
        $url = str_replace('/SISURAT', '', $url); // Adjust URL if necessary

        // Handle unsupported HTTP methods
        if (!isset(self::$routes[$method])) {
            http_response_code(405);
            show405();
            return;
        }

        if (isset(self::$routes[$method])) {
            foreach (self::$routes[$method] as $routeUrl => $target) {
                $pattern = preg_replace('/\{[^\/]+\}/', '([^/]+)', $routeUrl);
                if (preg_match('#^' . $pattern . '$#', $url, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    array_shift($matches);

                    // Extract query parameters
                    $queryString = $_SERVER['QUERY_STRING'] ?? ''; // Check if QUERY_STRING is set
                    parse_str($queryString, $queryParams); // Use empty string if not set
                    $params = array_merge($params, $queryParams); // Combine route parameters and query parameters
                    if (is_array($target)) {
                        $class = $target[0];
                        $method = $target[1];
                        if (class_exists($class) && method_exists($class, $method)) {
                            $instance = new $class();
                            call_user_func_array([$instance, $method], $matches);
                            return;
                        } else {
                            show400();
                            throw new Exception("Class or method not found");
                            return;
                        }
                    } else if (is_callable($target)) {
                        call_user_func_array($target, $matches);
                        return;
                    } else {
                        show400();
                        throw new Exception("Target is not callable");
                        return;
                    }
                }
            }
        }
        http_response_code(404);
        show404();

        return;
    }
}
