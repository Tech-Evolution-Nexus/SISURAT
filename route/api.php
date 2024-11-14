<?php

use app\controllers\api\AuthApiController;
use app\controllers\api\BeritaApiController;
use app\controllers\api\KkApiController;
use app\controllers\api\SuratApiController;
use app\controllers\BeritaController;
use app\services\Router;

//surat
// Router::addRoute("GET", "/getform/:id", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/jenissurat", [SuratApiController::class, "getdataall"]);
Router::addRoute("GET", "/jenissurat/{id}/{ids}", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/getpengajuan/{nik}/{status}", [SuratApiController::class, "getPengajuan"]);

Router::addRoute("GET", "/getlistkk/{id}", [KkApiController::class, "getdatakk"]);
Router::addRoute("GET", "/getlistsurat", [KkApiController::class, "getdatasurat"]);

Router::addRoute("GET", "/getberita", [BeritaApiController::class, "getBerita"]);
Router::addRoute("GET", "/detailberita/{id}", [BeritaApiController::class, "getdetailberita"]);

Router::addRoute("POST", "/login", [AuthApiController::class, "login"]);
Router::addRoute("POST", "/register", [AuthApiController::class, "register"]);
Router::addRoute("POST", "/veriv", [AuthApiController::class, "veriv"]);
Router::addRoute("POST", "/aktivasi", [AuthApiController::class, "aktivasi"]);







