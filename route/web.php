<?php

use app\controllers\AuthController;
use app\controllers\KartuKeluargaController;
use app\controllers\RT_RWController;
use app\controllers\SuratController;
use app\controllers\SuratMasukSelesaiController;
use app\services\Router;

//surat
Router::addRoute("GET", "/admin/surat", [SuratController::class, "index"]);
Router::addRoute("POST", "/admin/surat", [SuratController::class, "add"]);
Router::addRoute("GET", "/admin/esurat/{id}", [SuratController::class, "getedit"]);
Router::addRoute("GET", "/admin/dsurat/{id}", [SuratController::class, "deletedata"]);
Router::addRoute("POST", "/admin/editsurat/{id}", [SuratController::class, "edit"]);

Router::addRoute("GET", "/admin/surat-selesai", [SuratMasukSelesaiController::class, "index"]);
Router::addRoute("GET", "/admin/surat-selesai/{id}", [SuratMasukSelesaiController::class, "getdata"]);






//kk
Router::addRoute("GET", "/admin/kartu-keluarga", [KartuKeluargaController::class, "index"]);
Router::addRoute("GET", "/admin/kartu-keluarga/create", [KartuKeluargaController::class, "create"]);
Router::addRoute("POST", "/admin/kartu-keluarga", [KartuKeluargaController::class, "store"]);
Router::addRoute("GET", "/admin/kartu-keluarga/:id/edit", [KartuKeluargaController::class, "edit"]);
Router::addRoute("POST", "/admin/kartu-keluarga/:id", [KartuKeluargaController::class, "update"]);

// RT DAN RW 
// RW
Router::addRoute("GET", "/admin/master-rw", [RT_RWController::class, "indexRW"]);
Router::addRoute("GET", "/admin/master-rw/ajax-rw/:id", [RT_RWController::class, "ajaxRW"]);
Router::addRoute("GET", "/admin/master-rw/ajax-masyarakat/:id", [RT_RWController::class, "ajaxMasyarakat"]);
Router::addRoute("GET", "/admin/master-rw/create", [RT_RWController::class, "createRW"]);
Router::addRoute("POST", "/admin/master-rw", [RT_RWController::class, "storeRW"]);
Router::addRoute("POST", "/admin/master-rw/:id", [RT_RWController::class, "editRW"]);
// RW
Router::addRoute("GET", "/admin/master-rt/:rw-id", [RT_RWController::class, "indexRT"]);
Router::addRoute("GET", "/admin/master-rt/:rw-id/create", [RT_RWController::class, "createRT"]);
Router::addRoute("POST", "/admin/master-rt/:rw-id", [RT_RWController::class, "storeRT"]);
Router::addRoute("POST", "/admin/master-rt/:rw-id/:id", [RT_RWController::class, "editRT"]);

// login 
Router::addRoute("GET", "/login", [AuthController::class, "index"]);
Router::addRoute("POST", "/login", [AuthController::class, "authentic"]);
Router::addRoute("GET", "/dashbord", [AuthController::class, "authentic"]);
Router::addRoute("GET", "/lupapassword", [AuthController::class, 'lupaPassword']);
Router::addRoute("POST", "/lupapassword", [AuthController::class, 'kirimLinkReset']);
Router::addRoute("POST", "/sendemail", [AuthController::class, 'sendemail']);

//ganti password
Router::addRoute("GET", "/ganti-password", [AuthController::class, "gantiPassword"]);
Router::addRoute("POST", "/ganti-password", [AuthController::class, "gantiPasswordStore"]);

