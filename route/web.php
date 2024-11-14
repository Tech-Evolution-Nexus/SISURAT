<?php

use app\controllers\AnggotaKeluargaController;
use app\controllers\AuthController;
use app\controllers\BeritaController;
use app\controllers\DashController;
use app\controllers\KartuKeluargaController;
use app\controllers\LandingController;
use app\controllers\RT_RWController;
use app\controllers\SuratController;
use app\controllers\SuratMasukController;
use app\controllers\SuratMasukSelesaiController;
use app\services\Router;
use app\controllers\UserController;

// landing
Router::addRoute("GET", "/", [LandingController::class, "index"]);

//surat
Router::addRoute("GET", "/admin", [DashController::class, "index"]);
Router::addRoute("GET", "/admin/surat", [SuratController::class, "index"]);
Router::addRoute("POST", "/admin/surat", [SuratController::class, "add"]);
Router::addRoute("GET", "/admin/esurat/{id}", [SuratController::class, "getedit"]);
Router::addRoute("POST", "/admin/dsurat/{id}", [SuratController::class, "deletedata"]);
Router::addRoute("POST", "/admin/editsurat/{id}", [SuratController::class, "edit"]);

Router::addRoute("GET", "/admin/surat-selesai", [SuratMasukSelesaiController::class, "index"]);
Router::addRoute("GET", "/admin/surat-selesai/{id}", [SuratMasukSelesaiController::class, "getdata"]);

//USER
Router::addRoute("GET", "/admin/users", [UserController::class, "index"]);
Router::addRoute("GET", "/admin/users/create", [UserController::class, "create"]);
Router::addRoute("POST", "/admin/users/store", [UserController::class, "store"]);
Router::addRoute("GET", "/admin/users/{id}/edit", [UserController::class, "edit"]);
Router::addRoute("POST", "/admin/users/update/{id}", [UserController::class, "update"]);
Router::addRoute("POST", "/admin/users/{id}", [UserController::class, "delete"]);


//Kartu Keluarga
Router::addRoute("GET", "/admin/kartu-keluarga", [KartuKeluargaController::class, "index"]);
Router::addRoute("POST", "/admin/kartu-keluarga/import", [KartuKeluargaController::class, "import"]);
Router::addRoute("GET", "/admin/kartu-keluarga/create", [KartuKeluargaController::class, "create"]);
Router::addRoute("POST", "/admin/kartu-keluarga", [KartuKeluargaController::class, "store"]);
Router::addRoute("GET", "/admin/kartu-keluarga/{id}/edit", [KartuKeluargaController::class, "edit"]);
Router::addRoute("POST", "/admin/kartu-keluarga/{id}", [KartuKeluargaController::class, "update"]);
Router::addRoute("POST", "/admin/kartu-keluarga/{id}/delete", [KartuKeluargaController::class, "delete"]);

//Surat Masuk
Router::addRoute("GET", "/admin/surat-masuk", [SuratMasukController::class, "index"]);
Router::addRoute("GET", "/admin/surat-masuk/ajax/{idPengajuan}", [SuratMasukController::class, "ajaxPengajuan"]);
Router::addRoute("POST", "/admin/surat-masuk/{id}", [SuratMasukController::class, "updateStatus"]);


//anggota kk
Router::addRoute("GET", "/admin/kartu-keluarga/{nokk}/anggota-keluarga", [AnggotaKeluargaController::class, "index"]);
Router::addRoute("GET", "/admin/kartu-keluarga/{nokk}/anggota-keluarga/create", [AnggotaKeluargaController::class, "create"]);
Router::addRoute("POST", "/admin/kartu-keluarga/{nokk}/anggota-keluarga", [AnggotaKeluargaController::class, "store"]);
Router::addRoute("GET", "/admin/kartu-keluarga/{nokk}/anggota-keluarga/{nik}/edit", [AnggotaKeluargaController::class, "edit"]);
Router::addRoute("GET", "/admin/kartu-keluarga/{nokk}/anggota-keluarga/{nik}", [AnggotaKeluargaController::class, "show"]);
Router::addRoute("POST", "/admin/kartu-keluarga/{nokk}/anggota-keluarga/{nik}", [AnggotaKeluargaController::class, "update"]);
Router::addRoute("GET", "/admin/kartu-keluarga/{nokk}/anggota-keluarga/{nik}/delete", [AnggotaKeluargaController::class, "delete"]);

// RT DAN RW 
// RW
Router::addRoute("GET", "/admin/master-rw", [RT_RWController::class, "indexRW"]);
Router::addRoute("GET", "/admin/master-rw/ajax-rw/{nik}", [RT_RWController::class, "ajaxRW"]);
Router::addRoute("GET", "/admin/master-rw/ajax-masyarakat/{nik}", [RT_RWController::class, "ajaxMasyarakat"]);
Router::addRoute("GET", "/admin/msaster-rw/create", [RT_RWController::class, "createRW"]);
Router::addRoute("POST", "/admin/master-rw", [RT_RWController::class, "storeRW"]);
Router::addRoute("POST", "/admin/master-rw/{nik}", [RT_RWController::class, "updateRW"]);

// RT
Router::addRoute("GET", "/admin/master-rw/{rw}/master-rt", [RT_RWController::class, "indexRT"]);
Router::addRoute("GET", "/admin/master-rw/{rw}/master-rt/ajax-rt/{nik}", [RT_RWController::class, "ajaxRT"]);
Router::addRoute("GET", "/admin/master-rw/{rw}/master-rt/create", [RT_RWController::class, "createRT"]);
Router::addRoute("POST", "/admin/master-rw/{rw}/master-rt", [RT_RWController::class, "storeRT"]);
Router::addRoute("POST", "/admin/master-rw/{rw}/master-rt/{nik}", [RT_RWController::class, "updateRT"]);


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

Router::addRoute("GET", "/admin/berita", [BeritaController::class, "index"]);
Router::addRoute("POST", "/admin/berita", [BeritaController::class, "add"]);
Router::addRoute("GET", "/admin/getberita/{id}", [BeritaController::class, "getedit"]);
Router::addRoute("POST", "/admin/editberita/{id}", [BeritaController::class, "update"]);
Router::addRoute("POST", "/admin/deleteberita/{id}", [BeritaController::class, "delete"]);

Router::addRoute("GET", "/admin/assetssurat/{name}", [KomponenController::class, "getImageSurat"]);
Router::addRoute("GET", "/admin/assetsberita/{name}", [KomponenController::class, "getImageBerita"]);
