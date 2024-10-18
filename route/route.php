<?php

use app\controllers\AuthController;
use app\controllers\KartuKeluargaController;
use app\services\Route;

Route::addRoute("GET", "/login", function () {
    return view("auth/login");
});
Route::addRoute("GET", "/admin/kartu-keluarga", [KartuKeluargaController::class, "index"]);
Route::addRoute("GET", "/admin/kartu-keluarga/create", [KartuKeluargaController::class, "create"]);


Route::run();
