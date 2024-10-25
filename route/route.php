<?php

use controllers\AuthController;
use services\Route;

// Route::addRoute("GET", "/login", function () {
//     return view("auth/login");
// });
Route::addRoute("GET", "/login", [AuthController::class, "index"]);
Route::addRoute("POST", "/login", [AuthController::class, "authentic"]);
Route::addRoute("GET", "/dashbord", [AuthController::class, "authentic"]);


Route::run();
