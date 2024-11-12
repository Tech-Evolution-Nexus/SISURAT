<?php

namespace app\abstract;

class Controller
{
    protected function view($path, $data = [])
    {
        return view($path, $data);
    }
    protected function request($key)
    {
        return request($key);
    }
}
