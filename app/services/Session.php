<?php

class Session
{
    public function __construct()
    {
        session_start(); // Start the session in the constructor
    }

    public function flash($key, $data = null)
    {
        // Assuming get data
        if ($data) {
            $val = $_SESSION["flash"][$key] ?? null; // Use null coalescing operator to avoid undefined index notice
            unset($_SESSION["flash"][$key]);
            return $val;
        }

        $_SESSION["flash"][$key] = $data;
    }

    public function set($key, $data)
    {
        $_SESSION[$key] = $data;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null; // Use null coalescing operator for safety
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
