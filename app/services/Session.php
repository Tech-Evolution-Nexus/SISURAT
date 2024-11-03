<?php

namespace app\services;

class Session
{


    public function flash($key, $data = null)
    {
        // Assuming get data
        if (!$data) {
            $val = $_SESSION["flash"][$key] ?? null; // Use null coalescing operator to avoid undefined index notice
            unset($_SESSION["flash"][$key]);
            return $val;
        }

        $_SESSION["flash"][$key] = $data;
    }
    public function error($key, $data = null)
    {
        // Assuming get data
        if (!$data) {
            $val = $_SESSION["error"][$key] ?? null; // Use null coalescing operator to avoid undefined index notice
            unset($_SESSION["error"][$key]);
            return $val;
        }

        $_SESSION["error"][$key] = $data;
    }
    public function has($key)
    {
        return isset($_SESSION["flash"][$key]) || isset($_SESSION["error"][$key]);
    }

    public function set($key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null; // Use null coalescing operator for safety
    }
    public function all()
    {
        return $_SESSION ?? []; // Use null coalescing operator for safety
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function removeAll()
    {
        session_reset();
        session_destroy();
    }
}
