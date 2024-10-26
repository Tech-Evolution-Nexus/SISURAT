<?php

use app\controllers\AuthController;
use app\controllers\KartuKeluargaController;
use app\controllers\RT_RWController;
use app\services\Route;

Route::addRoute("GET", "/admin/kartu-keluarga", [KartuKeluargaController::class, "index"]);
Route::addRoute("GET", "/admin/kartu-keluarga/create", [KartuKeluargaController::class, "create"]);
Route::addRoute("POST", "/admin/kartu-keluarga", [KartuKeluargaController::class, "store"]);
Route::addRoute("GET", "/admin/kartu-keluarga/:id", [KartuKeluargaController::class, "edit"]);

// RT DAN RW 
// RW
Route::addRoute("GET", "/admin/master-rw", [RT_RWController::class, "indexRW"]);
Route::addRoute("GET", "/admin/master-rw/ajax-rw/:id", [RT_RWController::class, "ajaxRW"]);
Route::addRoute("GET", "/admin/master-rw/ajax-masyarakat/:id", [RT_RWController::class, "ajaxMasyarakat"]);
Route::addRoute("GET", "/admin/master-rw/create", [RT_RWController::class, "createRW"]);
Route::addRoute("POST", "/admin/master-rw", [RT_RWController::class, "storeRW"]);
Route::addRoute("POST", "/admin/master-rw/:id", [RT_RWController::class, "editRW"]);
// RW
Route::addRoute("GET", "/admin/master-rt/:rw-id", [RT_RWController::class, "indexRT"]);
Route::addRoute("GET", "/admin/master-rt/:rw-id/create", [RT_RWController::class, "createRT"]);
Route::addRoute("POST", "/admin/master-rt/:rw-id", [RT_RWController::class, "storeRT"]);
Route::addRoute("POST", "/admin/master-rt/:rw-id/:id", [RT_RWController::class, "editRT"]);

// login 
Route::addRoute("GET", "/login", [AuthController::class, "index"]);
Route::addRoute("POST", "/login", [AuthController::class, "authentic"]);
Route::addRoute("GET", "/dashbord", [AuthController::class, "authentic"]);
Route::addRoute("GET", "/lupapassword", [AuthController::class, 'lupaPassword']);
Route::addRoute("POST", "/lupapassword", [AuthController::class, 'kirimLinkReset']);
Route::addRoute("POST", "/sendemail", [AuthController::class, 'sendemail']);

//ganti password
Route::addRoute("GET", "/ganti-password", [AuthController::class, "gantiPassword"]);
Route::addRoute("POST", "/ganti-password", [AuthController::class, "gantiPasswordStore"]);

Route::run();
