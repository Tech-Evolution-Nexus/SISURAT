<?php

namespace app\controllers;

use app\interface\Controller;
use app\services\Database;
use app\models\KartuKeluargaModel;
use app\models\MasyarakatModel;
class AuthController extends Controller
{ 
    public  function index()
    {

        return view("auth.login");
    }
}
