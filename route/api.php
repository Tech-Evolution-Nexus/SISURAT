<?php

use app\controllers\api\SuratApiController;
use app\services\Router;

//surat
// Router::addRoute("GET", "/getform/:id", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/jenissurat", [SuratApiController::class, "getdataall"]);
Router::addRoute("GET", "/jenissurat/{id}/{ids}", [SuratApiController::class, "getform"]);
Router::addRoute("GET", "/s/{id}", [SuratApiController::class, "getlampiran"]);

