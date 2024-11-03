<?php

use app\controllers\AnggotaKeluargaController;
use app\controllers\AuthController;
use app\controllers\KartuKeluargaController;
use app\controllers\RT_RWController;
use app\controllers\SuratController;
use app\services\Router;

//surat
Router::addRoute("GET", "/admin/surat", [SuratController::class, "index"]);
Router::addRoute("POST", "/admin/surat", [SuratController::class, "add"]);
Router::addRoute("GET", "/test", function () {
    return view("apalah");
});


//kk
Router::addRoute("GET", "/admin/kartu-keluarga", [KartuKeluargaController::class, "index"]);
Router::addRoute("GET", "/admin/kartu-keluarga/create", [KartuKeluargaController::class, "create"]);
Router::addRoute("POST", "/admin/kartu-keluarga", [KartuKeluargaController::class, "store"]);
Router::addRoute("GET", "/admin/kartu-keluarga/:id/edit", [KartuKeluargaController::class, "edit"]);
Router::addRoute("POST", "/admin/kartu-keluarga/:id", [KartuKeluargaController::class, "update"]);
Router::addRoute("GET", "/admin/kartu-keluarga/:id/delete", [KartuKeluargaController::class, "delete"]);


//anggota kk
Router::addRoute("GET", "/admin/kartu-keluarga/:nokk/anggota-keluarga", [AnggotaKeluargaController::class, "index"]);
Router::addRoute("GET", "/admin/kartu-keluarga/:nokk/anggota-keluarga/create", [AnggotaKeluargaController::class, "create"]);
Router::addRoute("POST", "/admin/kartu-keluarga/:nokk/anggota-keluarga", [AnggotaKeluargaController::class, "store"]);
Router::addRoute("GET", "/admin/kartu-keluarga/:nokk/anggota-keluarga/:nik/edit", [AnggotaKeluargaController::class, "edit"]);
Router::addRoute("POST", "/admin/kartu-keluarga/:nokk/anggota-keluarga/:nik", [AnggotaKeluargaController::class, "update"]);
Router::addRoute("GET", "/admin/kartu-keluarga/:nokk/anggota-keluarga/:nik/delete", [AnggotaKeluargaController::class, "delete"]);

// RT DAN RW 
// RW
Router::addRoute("GET", "/admin/master-rw", [RT_RWController::class, "indexRW"]);
Router::addRoute("GET", "/admin/master-rw/ajax-rw/:nik", [RT_RWController::class, "ajaxRW"]);
Router::addRoute("GET", "/admin/master-rw/ajax-masyarakat/:nik", [RT_RWController::class, "ajaxMasyarakat"]);
Router::addRoute("GET", "/admin/master-rw/create", [RT_RWController::class, "createRW"]);
Router::addRoute("POST", "/admin/master-rw", [RT_RWController::class, "storeRW"]);
Router::addRoute("POST", "/admin/master-rw/:nik", [RT_RWController::class, "updateRW"]);

// RT
Router::addRoute("GET", "/admin/master-rw/:rw", [RT_RWController::class, "indexRT"]);
Router::addRoute("GET", "/admin/master-rw/:rw/ajax-rt/:nik", [RT_RWController::class, "ajaxRT"]);
Router::addRoute("GET", "/admin/master-rw/:rw/ajax-masyarakat/:nik", [RT_RWController::class, "ajaxMasyarakat"]);
Router::addRoute("GET", "/admin/master-rw/:rw/create", [RT_RWController::class, "createRT"]);
Router::addRoute("POST", "/admin/master-rw/:rw", [RT_RWController::class, "storeRT"]);
Router::addRoute("POST", "/admin/master-rw/:rw/:nik", [RT_RWController::class, "updateRT"]);

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

Router::run();
