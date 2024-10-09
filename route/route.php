<?php

use controllers\AuthController;
use services\Route;

Route::addRoute("GET", "/login", function () {
    return view("auth/login");
});


Route::run();
