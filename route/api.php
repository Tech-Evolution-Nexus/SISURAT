<?php

use app\controllers\api\KkApiController;
use app\controllers\api\SuratApiController;
use app\services\Router;

//surat
// Router::addRoute("GET", "/getform/:id", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/jenissurat", [SuratApiController::class, "getdataall"]);
Router::addRoute("GET", "/jenissurat/{id}/{ids}", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/s/{id}", [SuratApiController::class, "getlampiran"]);
Router::addRoute("GET", "/getpengajuan/{nik}/{status}", [SuratApiController::class, "getPengajuan"]);
Router::addRoute("GET", "/getlistkk/{id}", [KkApiController::class, "getdatakk"]);
Router::addRoute("GET", "/getlistsurat", [KkApiController::class, "getdatasurat"]);

Router::addRoute("GET", "/getberita", [BeritaApiController::class, "getBerita"]);
Router::addRoute("GET", "/detailberita/{id}", [BeritaApiController::class, "getdetailberita"]);
Router::addRoute("POST", "/test", function () {
    $file = request("file");
    return response($file);
});
