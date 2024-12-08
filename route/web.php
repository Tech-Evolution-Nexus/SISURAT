<?php

use app\controllers\AboutController;
use app\controllers\AnggotaKeluargaController;
use app\controllers\AuthController;
use app\controllers\BeritaController;
use app\controllers\DashController;
use app\controllers\FormatSuratController;
use app\controllers\KartuKeluargaController;
use app\controllers\KomponenController;
use app\controllers\LandingController;
use app\controllers\RT_RWController;
use app\controllers\SuratController;
use app\controllers\SuratMasukController;
use app\controllers\SuratMasukSelesaiController;
use app\services\Router;
use app\controllers\ProfileController;
use app\controllers\UserController;

// landing
Router::addRoute("GET", "/", [LandingController::class, "index"]);
Router::addRoute("GET", "/berita", [LandingController::class, "berita"]);
Router::addRoute("GET", "/berita/{id}", [LandingController::class, "beritaDetail"]);

//surat
Router::addRoute("GET", "/admin", [DashController::class, "index"]);
Router::addRoute("GET", "/admin/surat", [SuratController::class, "index"]);
Router::addRoute("GET", "/admin/surat/create", [SuratController::class, "create"]);
Router::addRoute("POST", "/admin/surat", [SuratController::class, "store"]);
Router::addRoute("GET", "/admin/surat/{id}/edit", [SuratController::class, "edit"]);
Router::addRoute("GET", "/admin/surat/{id}", [SuratController::class, "show"]);
Router::addRoute("POST", "/admin/surat/{id}/delete", [SuratController::class, "delete"]);
Router::addRoute("POST", "/admin/surat/{id}", [SuratController::class, "update"]);

//format surat
Router::addRoute("GET", "/admin/format-surat", [FormatSuratController::class, "index"]);
Router::addRoute("GET", "/admin/format-surat/create", [FormatSuratController::class, "create"]);
Router::addRoute("POST", "/admin/format-surat", [FormatSuratController::class, "store"]);
Router::addRoute("GET", "/admin/format-surat/{id}/edit", [FormatSuratController::class, "edit"]);
Router::addRoute("POST", "/admin/format-surat/{id}", [FormatSuratController::class, "update"]);
Router::addRoute("POST", "/admin/format-surat/{id}/delete", [FormatSuratController::class, "delete"]);


//surat selesai
Router::addRoute("GET", "/admin/surat-selesai", [SuratMasukSelesaiController::class, "index"]);
Router::addRoute("GET", "/admin/surat-selesai/{id}", [SuratMasukSelesaiController::class, "getdata"]);
Router::addRoute("GET", "/admin/surat-selesai/export/{id}", [SuratMasukSelesaiController::class, "exportPengajuan"]);
Router::addRoute("GET", "/admin/surat-selesai/detail/{idPengajuan}", [SuratMasukSelesaiController::class, "detail"]);

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
Router::addRoute("POST", "/admin/master-rw/{nik}/update-status", [RT_RWController::class, "updateStatusRW"]);

// RT
Router::addRoute("GET", "/admin/master-rw/{rw}/master-rt", [RT_RWController::class, "indexRT"]);
Router::addRoute("GET", "/admin/master-rw/{rw}/master-rt/ajax-rt/{nik}", [RT_RWController::class, "ajaxRT"]);
Router::addRoute("GET", "/admin/master-rw/{rw}/master-rt/create", [RT_RWController::class, "createRT"]);
Router::addRoute("POST", "/admin/master-rw/{rw}/master-rt", [RT_RWController::class, "storeRT"]);
Router::addRoute("POST", "/admin/master-rw/{rw}/master-rt/{nik}", [RT_RWController::class, "updateRT"]);
Router::addRoute("POST", "/admin/master-rw/{rw}/master-rt/{nik}/update-status", [RT_RWController::class, "updateStatusRT"]);


// login 
Router::addRoute("GET", "/login", [AuthController::class, "index"]);
Router::addRoute("POST", "/login", [AuthController::class, "authentic"]);
Router::addRoute("GET", "/logout", [AuthController::class, "logout"]);
Router::addRoute("GET", "/dashbord", [AuthController::class, "authentic"]);
Router::addRoute("GET", "/lupapassword", [AuthController::class, 'lupaPassword']);
Router::addRoute("POST", "/lupapassword", [AuthController::class, 'kirimLinkReset']);
Router::addRoute("POST", "/sendemail", [AuthController::class, 'sendemail']);

//ganti password
Router::addRoute("GET", "/ganti-password", [AuthController::class, "gantiPassword"]);
Router::addRoute("POST", "/ganti-password", [AuthController::class, "gantiPasswordStore"]);

//profile
Router::addRoute("GET", "/admin/profile", [ProfileController::class, "profile"]);
Router::addRoute("POST", "/admin/profile", [ProfileController::class, "profile"]);
Router::addRoute("POST", "/upload-profile-picture", [ProfileController::class, "uploadPP"]);
// Router::addRoute("POST", "/upload-profile-picture", [ProfileController::class, "uploadPP"]);

//tentang
Router::addRoute("GET", "/admin/tentangAplikasi", [AboutController::class, "index"]);
Router::addRoute("POST", "/admin/tentangAplikasi", [AboutController::class, "update_about"]);


Router::addRoute("GET", "/admin/berita", [BeritaController::class, "index"]);
Router::addRoute("POST", "/admin/berita", [BeritaController::class, "add"]);
Router::addRoute("GET", "/admin/getberita/{id}", [BeritaController::class, "getedit"]);
Router::addRoute("POST", "/admin/editberita/{id}", [BeritaController::class, "update"]);
Router::addRoute("POST", "/admin/deleteberita/{id}", [BeritaController::class, "delete"]);

Router::addRoute("GET", "/admin/assetssurat/{name}", [KomponenController::class, "getImageSurat"]);
Router::addRoute("GET", "/admin/assetsberita/{name}", [KomponenController::class, "getImageBerita"]);
Router::addRoute("GET", "/admin/assets-kartu-keluarga/{name}", [KomponenController::class, "getImageKartuKeluarga"]);
Router::addRoute("GET", "/admin/assets-lampiran/{name}", [KomponenController::class, "getImageLampiran"]);
Router::addRoute("GET", "/admin/assetsmasyarakat/{name}", [KomponenController::class, "getImagemasyarakat"]);


//handle ckeditor image upload
Router::addRoute("POST", "/admin/imageupload", function () {
    $file = request("upload");
    $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $randomName = uniqid() . '.' . $file_extension;
    $fileUpload = new FileUploader();
    $fileUpload->setFile($file);
    $fileUpload->setTarget(storagePath("public", "/assets/" . $randomName));
    $fileUpload->upload();

    return response(["url" => url("/assets/" . $randomName)]);
});
Router::addRoute("GET", "/admin/assetsverif/{name}", [KomponenController::class, "getImageverif"]);
Router::addRoute("GET", "/admin/assetsprofile/{name}", [KomponenController::class, "getImageprofile"]);
