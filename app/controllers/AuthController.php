<?php

namespace app\controllers;

use PHPUnit\Framework\TestCase;

class AuthController extends TestCase
{
    public  function index()
    {

        return view("/login");
    }
}
