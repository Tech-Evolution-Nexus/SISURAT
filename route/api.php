<?php

use app\controllers\api\AuthApiController;
use app\controllers\api\BeritaApiController;
use app\controllers\api\KkApiController;
use app\controllers\api\MasyarakatApiController;
use app\controllers\api\PengajuanSuratApiController;
use app\controllers\api\profilEapIcontrolleR;
use app\controllers\api\SuratApiController;
use app\controllers\SuratMasukSelesaiController;
use app\services\Router;

//surat
// Router::addRoute("GET", "/getform/:id", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/getlistsurat/{data}", [SuratApiController::class, "getdataall"]);
Router::addRoute("GET", "/getdataform/{nik}/{ids}", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/detailhistory/{idpengajuan}", [SuratApiController::class, "detailhistory"]);
Router::addRoute("POST", "/pengajuanpembatalan", [SuratApiController::class, "dibatalkan"]);


Router::addRoute("POST", "/approval-pengajuan/{nik}/{id_pengajuan}", [PengajuanSuratApiController::class, "approvalPengajuan"]);

Router::addRoute("GET", "/getpengajuan/{nik}/{status}", [PengajuanSuratApiController::class, "getPengajuan"]);
Router::addRoute("GET", "/list-pengajuan/{nik}/{status}", [PengajuanSuratApiController::class, "getListPengajuan"]);
Router::addRoute("GET", "/pengajuan-detail/{id_pengajuan}", [PengajuanSuratApiController::class, "getDetailPengajuan"]);


Router::addRoute("GET", "/getlistkk/{id}", [KkApiController::class, "getdatakk"]);

Router::addRoute("GET", "/getberita/{data}", [BeritaApiController::class, "getBerita"]);
Router::addRoute("GET", "/detailberita/{id}", [BeritaApiController::class, "getdetailberita"]);

Router::addRoute("POST", "/sendpengajuansuratmasyarakat", [PengajuanSuratApiController::class, "sendsurmas"]);

Router::addRoute("POST", "/login", [AuthApiController::class, "login"]);
Router::addRoute("POST", "/register", [AuthApiController::class, "register"]);
Router::addRoute("POST", "/veriv", [AuthApiController::class, "veriv"]);
Router::addRoute("POST", "/aktivasi", [AuthApiController::class, "aktivasi"]);
Router::addRoute("POST", "/sendemail", [AuthApiController::class, "sendemail"]);
Router::addRoute("POST", "/reset-password", [AuthApiController::class, "resetpassword"]);
Router::addRoute("POST", "/ganti-password", [AuthApiController::class, "gantipassword"]);



Router::addRoute("GET", "/surat-selesai/export/{id}", [SuratMasukSelesaiController::class, "exportPengajuan"]);

Router::addRoute("GET", "/getverifmasyarakat", [MasyarakatApiController::class, "getverifmasyarakat"]);
Router::addRoute("POST", "/tolakverifmasyarakat", [MasyarakatApiController::class, "tolakverifmasyarakat"]);
Router::addRoute("POST", "/accverifmasyarakat", [MasyarakatApiController::class, "accverifmasyarakat"]);
Router::addRoute("GET", "/getdash/{nik}", [MasyarakatApiController::class, "dadashboardrt"]);
Router::addRoute("GET", "/getdetailver/{nik}", [MasyarakatApiController::class, "detailprofilever"]);



Router::addRoute("GET", "/get-user-info/{nik}", [profilEapIcontrolleR::class, "getdatauser"]);
