<?php

namespace app\controllers;

use app\abstract\Controller;

class LandingController extends Controller
{
    public function index()
    {
        return $this->view("landing");
    }
}
