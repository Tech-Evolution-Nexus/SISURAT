<?php

namespace app\services;

class Redirector
{

    public function to($url, $statusCode = 302)
    {
        $url = url($url);
        header("Location: $url", true, $statusCode);
        exit;
    }

    public function back($statusCode = 302)
    {
        if (!empty($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER'], true, $statusCode);
        } else {
            $this->to('/'); // Fallback to home if no referrer
        }
        exit();
    }


    public function withInput($inputs = [])
    {
        foreach ($inputs as $key => $input) {
            session()->flash($key, $input);
        }
        return $this;
    }
    public function with($key, $message)
    {
        session()->flash($key, $message);
        return $this;
    }
}
