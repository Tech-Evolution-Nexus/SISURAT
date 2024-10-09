<?php

namespace controllers;

class AuthController
{
    public  function index()
    {
        var_dump("dsa");

        return view("auth/login");
    }
}
